<?php
/**
 * Handles star toggle for emails
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\EscortAdmin\Emails;

use Illuminate\Http\Request;

class StarEmailController extends Controller
{
    /**
     * Handles starring or unstarring an email
     *
     * @param String $emailId
     */
    public function handle($emailId)
    {
        $email = $this->emailRepository->find($emailId);

        if ($email->isStarred()) {
            $this->emailRepository->unStarEmail($email);
        } else {
            $this->emailRepository->markEmailAsStarred($email);
        }

        return json_encode($this->emailRepository->find($emailId)->toArray());
    }
}
