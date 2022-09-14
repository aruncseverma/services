<?php
/**
 * controls user subscription to newsletter
 * 
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\Index\Subscription;

use App\Http\Controllers\Controller;
use App\Repository\NewsletterRepository;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{

    public function __construct(NewsletterRepository $repo)
    {
        $this->repository = $repo;
    }

    /**
     * handles intended function
     *
     * @param Request $request
     * @return void
     */
    public function handle(Request $request)
    {
        $this->validateRequest($request);
        $params = [
            'email' => $request->email,
            'is_subscribed' => 1
        ];

        $result = $this->repository->save($params);

        if ($result) {
            $this->notifySuccess(__('Successfully subscribed.'));
        } else {
            $this->notifyError(__('Something went wrong. Please try again later'));
        }

        return back();
    }

    /**
     * validate request input
     *
     * @param Request $request
     * @return void
     */
    protected function validateRequest(Request $request) : void
    {
        $rules = [
            'email' => ['required', 'email'],
        ];

        // validate request
        $this->validate(
            $request,
            $rules
        );
    }
}
