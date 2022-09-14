<?php

namespace App\Http\Controllers\Index\Agency;

class ProfileController extends Controller
{

    public function view(string $username)
    {
        $this->setTitle(__('Agency Profile'));
        $details = $this->agencyRepository->getProfile($username);

        return view('Index::agency_profile.index', [
            'agency' => $details,
            'isFavorited' => false,
            'isFollowed' => false
        ]);
    }
}