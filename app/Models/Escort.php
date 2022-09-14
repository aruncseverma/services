<?php
/**
 * escort user eloquent model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use App\Support\Entity;
use App\Repository\CountryRepository;
use App\Repository\AttributeRepository;
use Illuminate\Database\Eloquent\Relations;
use App\Notifications\EscortAdmin\Auth\ResetPasswordNotification;
use App\Notifications\EscortAdmin\AccountSettings\ChangeEmailNotification;
use App\Repository\VipMembershipRepository;

class Escort extends User
{
    use Concerns\HasDescriptions;

    /**
     * escort user type value
     *
     * @const
     */
    const USER_TYPE = 'E';

    /**
     * relations to agency model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agency() : Relations\BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    /**
     * wraps parent::descriptions method
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function about() : Relations\HasMany
    {
        return $this->descriptions();
    }

    /**
     * relation to user location model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mainLocation() : Relations\HasOne
    {
        return $this->hasOne(UserLocation::class, 'user_id')
            ->where('type', UserLocation::MAIN_LOCATION_TYPE);
    }

    /**
     * relation to user location model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function additionalLocation() : Relations\HasMany
    {
        return $this->hasMany(UserLocation::class, 'user_id')
            ->where('type', UserLocation::ADDITIONAL_LOCATION_TYPE)
            ->with(['continent', 'country', 'state', 'city']);
    }

    /**
     * relation to escort language model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function escortLanguages() : Relations\HasMany
    {
        return $this->hasMany(EscortLanguage::class, 'user_id');
    }

    /**
     * relation to escort schedules
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules() : Relations\HasMany
    {
        return $this->hasMany(EscortSchedule::class, 'user_id');
    }

    /**
     * relation to escort rates
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rates() : Relations\HasMany
    {
        return $this->hasMany(EscortRate::class, 'user_id');
    }

    /**
     * relation to escort services model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services() : Relations\HasMany
    {
        return $this->hasMany(EscortService::class, 'user_id');
    }

    /**
     * relation to escort ranking model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rank() : Relations\HasOne
    {
        return $this->hasOne(EscortRanking::class, 'user_id');
    }

    /**
     * get escort ranking
     *
     * @return int
     */
    public function getRanking(): int
    {
        return $this->rank()->select('rank')->first()->rank ?? 0;
    }

    /**
     * {@inheritDoc}
     *
     * @return App\Support\Entity\EscortData
     */
    public function getUserDataAttribute()
    {
        $data = $this->userData()->get();
        $entity = new Entity\EscortData(['user' => $this]);

        foreach ($data as $model) {
            $entity->populate([
                $model->field => $model->content
            ]);
        }

        return $entity;
    }

    /**
     * get escort origin value
     *
     * @return string|null
     */
    public function getOriginAttribute()
    {
        $countries = app(CountryRepository::class);
        $data      = $this->userData;

        return ($country = $countries->find($data->originId)) ? $country->name : null;
    }

    /**
     * get escort origin code for flag display
     * @author Jhay Bagas <bagas.jhay@email.com>
     *
     * @return string|null
     */
    public function getOriginCodeAttribute() : ?string
    {
        $countries = app(CountryRepository::class);
        $data      = $this->userData;

        return ($country = $countries->find($data->originId)) ? $country->code : null;
    }

    /**
     * get escort service type
     * @author Jhay Bagas <bagas.jhay@gmail.com>
     *
     * @return string|null
     */
    public function getServiceTypeAttribute() : ?string
    {
        $data = $this->userData;
        return $data->serviceType;
    }

    /**
     * send an change email notification
     *
     * @param  string $token
     *
     * @return void
     */
    public function sendChangeEmailNotification($token) : void
    {
        $this->notify(new ChangeEmailNotification($token));
    }

    /**
     * relation to photos model (primary)
     * @author Jhay Bagas <bagas.jhay@gmail.com>
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profilePicture() : Relations\HasOne
    {
        return $this->hasOne(Photo::class, 'user_id')
            ->where('is_primary', true);
    }

    /**
     * accessor for profile_photo attribute
     *
     * @return App\Models\Photo|null
     */
    public function getProfilePhotoAttribute() : ?Photo
    {
        return $this->profilePicture;
    }

    /**
     * Retrieves the user's primary picture from the uploaded images
     * @author Jhay Bagas <bagas.jhay@gmail.com>
     *
     * @return string|null
     */
    public function getProfileImage() : ?string
    {
        $data = $this->profilePicture()->first();

        if ($data) {
            return route(
                'common.photo',
                [
                    'path' => $data->path,
                    'photo' => $data->getKey(),
                ]
            );
        }

        return null;
    }

    /**
     * Retrieves Membership plans purchased and their expiration dates
     *
     * @return Relations\HasMany
     */
    public function memberships() : Relations\HasMany
    {
        return $this->hasMany(VipSubscription::class, 'user_id')->where('vip_status', 'A')->orderBy('id', 'DESC');
    }

    /**
     * check if current day time has defined schedule
     *
     * @param  string $day
     * @param  string $time
     * @param  string $col
     *
     * @return boolean
     */
    public function hasSchedule($day, $time, $col = 'from') : bool
    {
        $schedules = $this->schedules;

        foreach ($schedules as $schedule) {
            if ($schedule->day === $day && $schedule->$col === $time) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if the escort is a valid VIP
     *
     * @param integer $id
     * @return boolean
     */
    public function isVip(int $id)
    {
        return ($this->getActiveMembershipPlan($id));
    }

    /**
     * Fetches the active VIP plan
     *
     * @param integer $id
     * @return VipSubscription
     */
    public function getActiveMembershipPlan(int $id) : ?VipSubscription
    {
        $repo = app(VipMembershipRepository::class);
        $params = [
            'user_id' => $id,
            'vip_status' => 'A'
        ];

        return $repo->getLatest($params);
    }

    /**
     * get rate for specific duration
     *
     * @param  integer $id
     * @param Currency|null $currency
     *
     * @return App\Models\EscortRate
     */
    public function getRate(int $id, Currency $currency) : EscortRate
    {
        $rates = $this->rates->where('currency_id', $currency->getKey());

        foreach ($rates as $rate) {
            if ($rate->rate_duration_id == $id) {
                return $rate;
            }
        }

        return $this->rates()->getModel();
    }

    /**
     * get escort service model for specific service
     *
     * @param  integer $id
     *
     * @return App\Models\EscortService
     */
    public function getService(int $id) : EscortService
    {
        $services = $this->services;

        foreach ($services as $service) {
            if ($service->getKey() === $id) {
                return $service;
            }
        }

        return $this->services()->getModel();
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * attribute accessor for cupiSze
     *
     * @return string|null
     */
    public function getCupSizeAttribute() : ?string
    {
        return $this->getAttributeDescription($this->userData->cupSizeId);
    }

    /**
     * attribute accessor for hairColor
     *
     * @return string|null
     */
    public function getHairColorAttribute() : ?string
    {
        return $this->getAttributeDescription($this->userData->hairColorId);
    }

    /**
     * attribute accessor for eyeColor
     *
     * @return string|null
     */
    public function getEyeColorAttribute() : ?string
    {
        return $this->getAttributeDescription($this->userData->eyeColorId);
    }

    /**
     * attribute accessor for ethnicity
     *
     * @return string|null
     */
    public function getEthnicityAttribute() : ?string
    {
        return $this->getAttributeDescription($this->userData->ethnicityId);
    }

    /**
     * get attribute description value
     *
     * @param  mixed $id
     *
     * @return string|null
     */
    protected function getAttributeDescription($id) : ?string
    {
        // get attributes repository
        $attributes = app(AttributeRepository::class);

        if (empty($id)) {
            return null;
        }

        $attribute = $attributes->find($id);

        return ($attribute)
            ? $attribute->getDescription(app()->getLocale())->content
            : null;
    }

    /**
     * attribute accessor for minRate
     *
     * @return float
     */
    public function getMinRateAttribute() : float
    {
        $rates = $this->rates;

        // sort rates by asc depending of what service does this escort have
        $sorted = $rates->sortBy(function ($rate) {
            return ($this->getAttribute('service_type') == 'I') ? $rate->incall : $rate->outcall;
        });

        $rate = $sorted->first();

        if (! $rate) {
            return 0.0;
        }

        return ($this->getAttribute('service_type') == 'I') ? $rate->incall : $rate->outcall;
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }
}
