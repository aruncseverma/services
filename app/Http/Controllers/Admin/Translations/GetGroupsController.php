<?php

namespace App\Http\Controllers\Admin\Translations;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GetGroupsController extends Controller
{
    /**
     * renders form view
     *
     * @param  Illuminate\Http\Request
     *
     * @return JsonResponse
     */
    public function view(Request $request)
    {
        return response()->json($this->repository->getGroups()->pluck('group'));
    }
}
