<?php

namespace App\Support\Validation;

use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class GoogleRecaptchaValidator extends Validator
{
    /**
     * {@inheritDoc}
     */
    public function validate(string $attribute, $value, array $parameters, ValidatorContract $validator): bool
    {
        $postRequest = array(
            'secret' => env('RECAPTCHA_SECRET_KEY', false),
            'remoteip' => request()->getClientIp(),
            'response' => $value
        );

        $cURLConnection = curl_init('https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);

        $jsonArrayResponse = json_decode($apiResponse, true);
        return $jsonArrayResponse['success'];
    }

    /**
     * {@inheritDoc}
     */
    public function replacer(string $message, string $attribute, string $rule, array $parameters): string
    {
        //return str_replace(':attribute', $attribute, $message);
        return 'Are you robot?';
    }
}
