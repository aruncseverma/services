<?php
/**
 * controller class for creating booking of user
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Http\Controllers\Index\Profile;

use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Repository\EscortBookingRepository;
use App\Models\Escort;

class AddBookingController extends Controller
{
    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        // notify and redirect if does not have any identifier
        if (! $id = $this->request->input('id')) {
            $this->notifyError(__('Booking Now requires identifier.'));
            return redirect()->back();
        }

        $escort = $this->getEscortById($id);
        if (! $escort) {
            $this->notifyError(__('Escort not found.'));
            return redirect()->back();
        }

        // validate request if passed then proceeds to saving booking
        $this->validateRequest();

        // save data
        $escort = $this->saveData($escort);

        // notify next request
        if ($escort) {
            $this->notifySuccess(__('Booking Now successfully saved.'));
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
            'firstname' => ['required'],
            'lastname' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required'],
            'message' => ['required', 'max:255'],
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
     * @param  App\Models\Escort|null $escort
     *
     * @return App\Models\Escort
     */
    protected function saveData(Escort $escort = null) : Escort
    {
        $repository = app(EscortBookingRepository::class);

        // save it
        $repository->store(
            [
                'firstname' => $this->request->input('firstname'),
                'lastname' => $this->request->input('lastname'),
                'email' => $this->request->input('email'),
                'phone' => $this->request->input('phone'),
                'message' => $this->request->input('message'),
            ],
            $escort
        );

        return $escort;
    }
}
