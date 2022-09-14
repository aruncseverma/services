<?php

namespace App\Http\Controllers\EscortAdmin\Emails;

class CheckEmailController extends RenderFormController
{
    /**
     * Handles email sending
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle()
    {
        $auth = $this->getAuthUser();
        $email = $this->request->input('email', '');
        $status = 0;
        $message = __('Email is required.');
        if (!empty($email)) {
            $user = $this->userRepository->findUserByEmail($email);
            if (!$user) {
                $message = __("Can't send email to {$email}. Email is not found on this server.");
            } else if ($auth->id == $user->id) {
                $message = __("You can't send email to yourself.");
            } else {
                $status = 1;
                $message = 'Ok';
            }
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
}
