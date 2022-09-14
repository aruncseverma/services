<?php

namespace App\Http\Controllers\Index\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Escort;
use App\Repository\EscortRepository;
use App\Models\User;
use App\Repository\EscortReportRepository;

class AddReportController extends Controller
{
    /**
     * laravel request object
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * escort repository instance
     *
     * @var App\Repository\EscortRepository
     */
    protected $escortRepo;

    /**
     * escort report repository instance
     *
     * @var App\Repository\FavoriteRepository
     */
    protected $reportRepo;

    /**
     * create instance of this controller
     *
     * @param Request                   $request
     * @param EscortRepository          $escortRepo
     * @param EscortReportRepository    $reportRepo
     */
    public function __construct(
        Request $request,
        EscortRepository $escortRepo,
        EscortReportRepository $reportRepo
    ) {
        $this->request = $request;
        $this->escortRepo = $escortRepo;
        $this->reportRepo = $reportRepo;
    }

    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $user = $this->getAuthUser();
        if (! $user) {
            $this->notifyError(__('Please login to proceed.'));
            return redirect()->back();
        }

        // notify and redirect if does not have any identifier
        if (! $username = $this->request->input('id')) {
            $this->notifyError(__('Report escort requires identifier.'));
            return redirect()->back();
        }

        $escort = $this->escortRepo->findUserByUsername($username);
        if (!$escort) {
            $this->notifyError(__('Escort not found.'));
            return redirect()->back();
        }

        // validate request if passed then proceeds to report an escort
        $this->validateRequest();

        // save data
        $user = $this->saveData($user, $escort);

        // notify next request
        if ($user) {
            $this->notifySuccess(__('Report successfully saved.'));
        } else {
            $this->notifyWarning(__('Unable to save current request. Please try again sometime'));
        }

        return redirect()->back();
    }

    /**
     * validate incoming request
     *
     * @return void
     */
    protected function validateRequest() : void
    {
        $rules = [
            'type' => ['required', 'max:25'],
            'content' => ['max:255'],
        ];

        // validate request
        $this->validate(
            $this->request,
            $rules
        );
    }

    /**
     * save data
     *
     * @param  User|null $user
     * @param  Escort|null $escort
     *
     * @return User
     */
    protected function saveData(User $user = null, Escort $escort) : User
    {
        // save it
        $this->reportRepo->store(
            [
                'customer_user_id' => $user->getKey(),
                'type' => $this->request->input('type') ?? '',
                'content' => $this->request->input('content') ?? ''
            ],
            $escort
        );

        return $user;
    }
}
