<?php

namespace App\Http\Controllers\MemberAdmin\AccountSettings;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Repository\CountryRepository;
use App\Repository\BanCountryRepository;

class UpdateBanCountriesController extends Controller
{
    /**
     * create instance
     *
     * @param App\Repository\BanCountryRepository $banRepository
     * @param App\Repository\CountryRepository    $countryRepository
     */
    public function __construct(BanCountryRepository $banRepository, CountryRepository $countryRepository)
    {
        $this->banRepository = $banRepository;
        $this->countryRepository = $countryRepository;
    }

    /**
     * handles incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request) : RedirectResponse
    {
        $this->validateRequest($request);

        $countryIds = $request->input('ban_countries.*', $request->input('ban_countries', []));
        if (!is_array($countryIds)) {
            $countryIds = explode(',', $countryIds);
        }
        if ($this->saveBanCountries($countryIds, $this->getAuthUser())) {
            $this->notifySuccess(__('Ban Countries updated successfully'));
        } else {
            $this->notifyWarning(__('Unable to save current request. Please try again sometime'));
        }

        return back()->withInput(['notify' => 'ban_countries']);
    }

    /**
     * validates incoming request data
     *
     * @throws Illuminate\Validation\ValidationException
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateRequest(Request $request) : void
    {
        $country = $this->countryRepository->getModel();

        $this->validate(
            $request,
            [
                'ban_countries' => [
                    Rule::exists($country->getTable(), $country->getKeyName())->where(function ($query) {
                        $query->where('is_active', true);
                    }),
                ]
            ]
        );
    }

    /**
     * save ban countries to user
     *
     * @param  array           $ids
     * @param  App\Models\User $user
     *
     * @return bool
     */
    protected function saveBanCountries(array $ids, User $user) : bool
    {
        // delete previously set
        foreach ($user->banCountries as $ban) {
            $this->banRepository->delete($ban->getKey());
        }

        // fetch information from records for each countries
        foreach ($ids as $id) {
            $country = $this->countryRepository->find($id);

            if (! $country) {
                continue;
            }

            $ban = $this->banRepository->store([], $user, $country);
        }

        return true;
    }
}
