<?php
/**
 * controller class for rendering Profile form
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Http\Controllers\Index\Profile;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\UserLocation;
use App\Repository\RateDurationRepository;
use App\Repository\UserViewRepository;
use App\Repository\AttributeRepository;
use App\Repository\LanguageRepository;
use App\Repository\PhotoRepository;
use App\Repository\UserVideoRepository;
use App\Repository\UserReviewRepository;
use App\Models\UserGroup;
use App\Models\User;
use App\Repository\UserFollowerRepository;
use App\Repository\FavoriteRepository;
//use App\Repository\EscortRepository;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

class RenderProfileController extends Controller
{
    /**
     * create view instance
     *
     * @return Illuminate\Contracts\View\View
     *         Illuminate\Http\RedirectResponse
     */
    public function view($username)
    {
        $auth = $this->getAuthUser();
        
        $user = $this->repository->findUserByUsername($username);
        if (! $user) {
            abort(404);
        }
        
        $raviewdata = DB::table('user_reviews')
        ->leftJoin('users', 'user_reviews.user_id', '=', 'users.id')
        ->where('user_reviews.object_id', $user->id)
        ->where('user_reviews.is_approved', '1')
        ->select('user_reviews.*', 'users.name as username')
        ->paginate(10);
        //$raviewdata->appends('profile/'.$user->id);
        //dd($raviewdata->lastPage());
        $user->reviews = $raviewdata;
        //
        // eye color
        $eyeColorOptions = $this->getEyeColorOptions();
        $user->eyeColor = '';
        if (!empty($eyeColorOptions)) {
            foreach ($eyeColorOptions as $option) {
                if ($option->id == $user->userData->eyeColorId) {
                    $user->eyeColor = $option->description->content;
                    break;
                }
            }
        }

        // hair color
        $hairColorOptions = $this->getHairColorOptions();
        $user->hairColor = '';
        if (!empty($hairColorOptions)) {
            foreach ($hairColorOptions as $option) {
                if ($option->id == $user->userData->hairColorId) {
                    $user->hairColor = $option->description->content;
                    break;
                }
            }
        }

        // hair length
        $hairLenght2LinerOptions = $this->getHairLength2LinerOptions();
        $user->hairLength = '';
        if (!empty($hairLenght2LinerOptions)) {
            foreach ($hairLenght2LinerOptions as $value => $label) {
                if ($value == $user->userData->hairLength2LinerId) {
                    $user->hairLength = $label;
                    break;
                }
            }
        }

        // orientation
        $orientation2LinerOptions = $this->getOrientation2LinerOptions();
        $user->orientation = '';
        if (!empty($orientation2LinerOptions)) {
            foreach ($orientation2LinerOptions as $value => $label) {
                if ($value == $user->userData->orientation2Liner) {
                    $user->orientation = $label;
                    break;
                }
            }
        }

        // ethnic
        $ethnicityOptions = $this->getEthnicityOptions();
        $user->ethnic = '';
        if (!empty($ethnicityOptions)) {
            foreach ($ethnicityOptions as $option) {
                if ($option->id == $user->userData->ethnicityId) {
                    $user->ethnic = $option->description->content;
                    break;
                }
            }
        }

        $user->bust = (isset($user->userData->bustId))?$user->userData->bustId:'--';
        $user->bloodtype = (isset($user->userData->bloodTypeId))?$user->userData->bloodTypeId:'--';
        $user->weight = (isset($user->userData->weightId))?$user->userData->weightId:'--';
        $user->height = (isset($user->userData->heightId))?$user->userData->heightId:'--';

        // home city
        $homeCity = [];
        if (!empty($user->mainLocation->city->name)) {
            $homeCity[] = $user->mainLocation->city->name;
        }
        if (!empty($user->mainLocation->state->name)) {
            $homeCity[] = $user->mainLocation->state->name;
        }
        if (!empty($user->mainLocation->country->name)) {
            $homeCity[] = $user->mainLocation->country->name;
        }
        $user->homeCity = !empty($homeCity) ? implode(',', $homeCity) : '';
        
        if (!empty($user->mainLocation->country->name)) {
            $user->country = $user->mainLocation->country->name;
        } else {
            $user->country = '';
        }

        if (!empty($user->mainLocation->state->name)) {
            $user->state = $user->mainLocation->state->name;
        } else {
            $user->state = '';
        }

        if (!empty($user->mainLocation->city->name)) {
            $user->city = $user->mainLocation->city->name;
        } else {
            $user->city = '';
        }

        $this->setTitle(__('Profile'));

        return view('Index::profile.index', [
            'auth' => $auth,
            'user' => $user,
            'durations' => $this->getUserDurations($user), // fees
            'languageProficiencyOptions' => $this->getLanguageProficiencyOptions(),
            'photos' => $this->getPhotos($user), // my photos
            'videos' => $this->getVideos($user), // my videos
            'ratingAverage' => app(UserReviewRepository::class)->getReviewRatingAverage($user), // statistics - rating
            'services' => $this->getServices($user), // services
            'schedules' => $this->getSchedules($user), // schedules
            'membership' => $this->getCurrentMembership($user), // statistics - validation
            'totalViews' => $this->getUserTotalViews($user), // statistics - views
            'destinations' => $this->getUserDestinations($user), // biography - destinations
            'shortAboutMe' => $this->getUserShortDescription($user), // about me - short description
            'isFollowed' => $this->isFollowed($user, $auth),
            'isFavorited' => $this->isFavorited($user, $auth),           
        ]);
    }

    /**
     * get gender options
     *
     * @return array
     */
    protected function getGenderOptions()
    {
        return [
            'M' => 'Male',
            'F' => 'Female',
            'B' => 'Bysexual'
        ];
    }

    /**
     * get orientation 2 liner options
     *
     * @return array
     */
    protected function getOrientation2LinerOptions()
    {
        return [
            'S' => 'Straight',
            'B' => 'Bisexual'
        ];
    }

    /**
     * get attribute options
     *
     * @return Illuminate\Support\Collection
     */
    protected function getAttributesByName($name = '')
    {
        if (empty($name)) {
            return false;
        }

        $repository = app(AttributeRepository::class);

        return $repository->findAll([
            'name' => $name,
            'is_active' => true
        ]);
    }

    /**
     * get ethnicity options
     *
     * @return Illuminate\Support\Collection
     */
    protected function getEthnicityOptions()
    {
        return $this->getAttributesByName('ethnicity');
    }

    /**
     * get hair color options
     *
     * @return Illuminate\Support\Collection
     */
    protected function getHairColorOptions()
    {
        return $this->getAttributesByName('hair_color');
    }

    /**
     * get eye color options
     *
     * @return Illuminate\Support\Collection
     */
    protected function getEyeColorOptions()
    {
        return $this->getAttributesByName('eye_color');
    }

    /**
     * get language proficiency options
     *
     * @return array
     */
    protected function getLanguageProficiencyOptions()
    {
        return [
            'G' => 'Good',
            'M' => 'Moderate',
            'E' => 'Expert',
        ];
    }

    /**
     * get hair length 2 liner options
     *
     * @return array
     */
    protected function getHairLength2LinerOptions()
    {
        $min = 0.5;
        $max = 20;
        $add = $min;
        $options = [];

        for ($val = $min; $val <= $max; $val += $add) {
            $options["$val"] = sprintf('%s inches', $val);
        }

        return $options;
    }

    /**
     *  Fetches one public and private photos
     *
     *  @param  App\Models\User $user
     *  @return array
     */
    protected function getPhotos($user) : Array
    {
        $repository = app(PhotoRepository::class);

        $primary = $repository->fetchPrimaryPhoto($user->getKey());
        $private = $repository->getUserPrivatePhotos($user);

        return [
            'public' => $primary ? $primary : '',
            'private' => (! $private->isEmpty()) ? $private->get(0) : ''
        ];
    }

    /**
     *  Fetches one public and private videos
     *
     *  @param  App\Models\User $user
     *  @return array
     */
    protected function getVideos($user) : Array
    {
        $repository = app(UserVideoRepository::class);

        $public = $repository->getUserPublicVideos($user);
        $private = $repository->getUserPrivateVideos($user);

        return [
            'public' => (! $public->isEmpty()) ? $public->get(0)->toArray() : '',
            'private' => (! $private->isEmpty()) ? $private->get(0)->toArray() : ''
        ];
    }

    /**
     *  get user total views
     *
     *  @param  App\Models\User $user
     *  @return integer
     */
    protected function getUserTotalViews($user) : int
    {
        $repository = app(UserViewRepository::class);
        $ipAddress = $this->request->ip();
        $result = $repository->findTodayViewByIp($ipAddress, $user);
        if (! $result) {
            $agent = new \Jenssegers\Agent\Agent;
            $repository->store([
                'ip_address' => $ipAddress,
                'device' => $agent->device(),
                'device_type' => $agent->deviceType(),
                'platform' => $agent->platform(),
                'browser' => $agent->browser(),
                'created_at' => Carbon::now(),
            ], $user);
        }

        return $repository->getTotalViews($user);
    }

    /**
     *  get user destinations
     *
     *  @param  App\Models\User $user
     *  @return string
     */
    protected function getUserDestinations(User $user) : string
    {
        $destinations = [];
        if ($user->additionalLocation) {
            foreach ($user->additionalLocation as $location) {
                $destinations[$location->country->name] = $location->country->name;
            }
        }
        return !empty($destinations) ? implode(', ', $destinations) : '';
    }

    /**
     *  get short description of user
     *
     *  @param  App\Models\User $user
     *  @return string
     */
    protected function getUserShortDescription($user) : string
    {
        $shortAboutMe = '';
        $maximumLength = 175;
        if ($user->description != null) {
            if ($user->description->content && strlen($user->description->content) > $maximumLength) {
                $shortAboutMe = str_limit($user->description->content, $maximumLength, ' ...');
            }
        }
        return $shortAboutMe;
    }

    /**
     *  get extra and standard services of user
     *
     *  @param  App\Models\User $user
     *  @return array
     */
    protected function getServices($user) : array
    {
        $extraServices = [];
        $standardServices = [];
        $fetishServices = [];
        $eroticServices = [];
        if ($user->services) {
            foreach ($user->services as $service) {
                switch ($service->type) {
                    case 'E':
                        $extraServices[] = $service->service->description->content;
                        break;
                    case 'S':
                        $standardServices[] = $service->service->description->content;
                        break;
                    case 'N':
                        $fetishServices[] = $service->service->description->content;
                        break;
                }
            }
            if (!empty($extraServices)) {
                $extraServices = $extraServices;
            }
            if (!empty($standardServices)) {
                $standardServices = $standardServices;
            }

            if (!empty($fetishServices)) {
                $fetishServices = $fetishServices;
            }
        }

        return [
            'extra' => $extraServices,
            'standard' => $standardServices,
            'fetish' => $fetishServices,
            'erotic' => $eroticServices,
        ];
    }

    /**
     *  get schedules of user
     *
     *  @param  App\Models\User $user
     *  @return array
     */
    protected function getSchedules($user) : array
    {
        $userSchedules = [];

        if ($user->schedules) {
            foreach ($user->schedules as $schedule) {
                if (!empty($schedule['day'])) {
                    $userSchedules[$schedule['day']] = $schedule;
                }
            }
        }

        return $userSchedules;
    }

    /**
     *  get current membership of user
     *
     *  @param  App\Models\User $user
     *  @return string
     */
    protected function getCurrentMembership($user) : string
    {
        $membership = 'Basic Member';

        if (optional($user->userGroup)->getKey() === UserGroup::SILVER_GROUP_ID) {
            $membership = 'Silver Member';
        } elseif (optional($user->userGroup)->getKey() === UserGroup::GOLD_GROUP_ID) {
            $membership = 'Gold Member';
        }

        return $membership;
    }

    /**
     *  get current membership of user
     *
     *  @param  App\Models\User $user
     *  @return Illuminate\Support\Collection
     */
    protected function getUserDurations($user) : Collection
    {
        $userId = $user->getKey();
        $currentLocale = app()->getLocale();
        $repository = app(RateDurationRepository::class);

        return $repository->getBuilder()
            ->with([
                'description' => function ($q) use ($currentLocale) {
                    $q->where('lang_code', '=', $currentLocale);
                },
                'escortRate' => function ($q) use ($userId) {
                    $q->where('user_id', '=', $userId);
                },
            ])
            ->where('is_active', 1)
            ->orderBy('position', 'asc')
            ->get();
    }

    /**
     *  get current membership of user
     *
     *  @param  App\Models\User $user
     *  @param  App\Models\User $user
     *  @return bool
     */
    protected function isFollowed($user, $auth): bool
    {
        if (!$user || !$auth) {
            return false;
        }
        $repository = app(UserFollowerRepository::class);
        $follower = $repository->findFollowerByFollowerId($auth->getKey(), $user);
        if (!$follower) {
            return false;
        }
        return true;
    }

    /**
     *  get current membership of user
     *
     *  @param  App\Models\User $user
     *  @param  App\Models\User $user
     *  @return bool
     */
    protected function isFavorited($user, $auth): bool
    {
        if (!$user || !$auth) {
            return false;
        }
        $repository = app(FavoriteRepository::class);
        $favorite = $repository->findFavoriteEscortByEscortId($user->getKey(), $auth);
        if (!$favorite) {
            return false;
        }
        return true;
    }

    public function ajaxPagination(Request $request)
    {
       
        $username = $request->username;
        $page = $request->page;
        $auth = $this->getAuthUser();
        $user = $this->repository->findUserByUsername($username);
        if (! $user) {
            abort(404);
        }
        
        $raviewdata = DB::table('user_reviews')
        ->leftJoin('users', 'user_reviews.user_id', '=', 'users.id')
        ->where('user_reviews.object_id', $user->id)
        ->where('user_reviews.is_approved', '1')
        ->select('user_reviews.*', 'users.name as username')
        ->paginate(10);

        

   
        if ($request->ajax()) {
            return view('Index::profile.presult', compact('raviewdata'));
        }
  
        //return view('ajaxPagination',compact('data'));
    }
}
