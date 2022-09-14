<?php
/**
 * Handles any form of email sending
 *
 * @author Jhay Bagas <bagas.jhay@email.com>
 */
namespace App\Http\Controllers\AgencyAdmin\Emails;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use DB;

class SendEmailController extends RenderFormController
{
    /**
     * Handles email sending
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $user = $this->getAuthUser();
        $this->validateFields($this->request);

        // extract all receipient
        $receiverEmails = $this->request->input('receipient');
        if (!is_array($receiverEmails)) {
            $receiverEmails = explode(',', $receiverEmails);
        }

        $receiverUsers = $this->users->getAllByEmails($receiverEmails)->keyBy('email');
        if (!$receiverUsers) {
            $this->notifyError(__("Receipient is invalid."));
            return redirect()->back();
        }

        // validate if all receipient emails is valid
        // and current user is not included in receipient emails
        foreach ($receiverEmails as $email) {
            $emailUser = $receiverUsers->get($email);
            if (!$emailUser) {
                $this->notifyError(__("Can't send email to {$email}. Email is not found on this server."));
                return redirect()->back()->withInput();
            }
            if ($emailUser->getKey() == $user->getKey()) {
                $this->notifyError(__("You can't send email to yourself."));
                return redirect()->back()->withInput();
            }
        }

        // save data
        $attributes = [
            'sender_user_id'    => $user->getKey(),
            //'recipient_user_id' => $emailUser->getKey(),
            'is_starred'        => false,
            'title'             => $this->request->input('subject'),
            'content'           => $this->request->input('content')
        ];

        try {
            DB::beginTransaction();
            foreach ($receiverEmails as $email) {
                $emailUser = $receiverUsers->get($email);
                $attributes['recipient_user_id'] = $emailUser->getKey();
                // Send email
                $this->emails->save($attributes);
            }
            DB::commit();
        } catch (\PDOException $e) {
            DB::rollback();
            $this->notifyError(__("Something went wrong."));
            return redirect()->back()->withInput();
        }

        return $this->redirectTo();
    }

    /**
     * get redirect url
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo() : RedirectResponse
    {
        $this->notifySuccess('Email successfully sent.');
        return redirect()->route('agency_admin.emails.manage')->with('message', 'Email successfully sent!');
    }

    /**
     * Validate items
     *
     * @param Illuminate\Http\Request $request
     * @return void
     */
    protected function validateFields(Request $request) : void
    {
        $rules = [
            'receipient' => ['required'],
            'subject'    => ['required'],
            'content'    => 'required',
        ];

        // validate request
        $this->validate(
            $request,
            $rules
        );
    }
}
