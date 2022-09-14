<?php
/**
 * Handles star toggle for emails
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 * @modified Mike Alvarez <michaeljpalvarez@gmail.com>
 */
namespace App\Http\Controllers\AgencyAdmin\Emails;

use App\Models\UserEmail;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StarEmailController extends Controller
{
    /**
     * handles starred of required email
     *
     * @param  App\Models\UserEmail $email
     *
     * @return string
     */
    public function handle(UserEmail $email) : JsonResponse
    {
        // invalid
        if ($email->recipient->getKey() != $this->getAuthUser()->getKey()) {
            return response()->json([], 401);
        }

        if ($email->isStarred()) {
            $this->emails->unStarEmail($email);
        } else {
            $this->emails->markEmailAsStarred($email);
        }

        return response()->json($email);
    }
}
