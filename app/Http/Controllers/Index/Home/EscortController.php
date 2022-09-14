<?php
/**
 * Controller for escorts together with filters
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\Index\Home;

use Illuminate\Http\Request;

class EscortController extends Controller
{
    /**
     * Fetches the escorts' list from database
     *
     * @param Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function findEscort(Request $request)
    {
        $escorts = $this->escortRepository->getAll();

        foreach($escorts as $key => $value) {
            $value->setAttribute('profile_picture', $value->getProfileImage());
            $value->setAttribute('age', $value->getAgeAttribute());
            $value->setAttribute('rate', $value->getRate($value->id));
            $value->setAttribute('service', $value->getService($value->id));
            $value->setAttribute('origin', $value->getOriginAttribute());
            $value->setAttribute('main_location', $value->mainLocation());
            $value->setAttribute('origin_code', strtolower($value->getOriginCodeAttribute()));
        }

        return json_encode($escorts->toArray());
    }
}
