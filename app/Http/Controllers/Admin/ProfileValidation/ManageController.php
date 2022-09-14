<?php
/**
 * controller class for managing escort private profile validation
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\ProfileValidation;

use App\Models\Escort;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Support\Concerns\NeedsUserGroups;

class ManageController extends Controller
{
    use NeedsUserGroups;

    /**
     * renders manage list
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index(Request $request) : View
    {
        $this->setTitle(__('Manage Private Profile Validation'));

        $search = array_merge(
            [
                'name' => null,
                'status' => 'pending',
                'user_group_id' => '*',
                'user_type' => Escort::USER_TYPE,
                'limit' => $limit = $this->getPageSize(),
            ],
            $request->query()
        );

        // status search corresponding search column
        if ($search['status'] === 'approved') {
            $search['is_approved'] = true;
        } elseif ($search['status'] === 'denied') {
            $search['is_denied'] = true;
        } elseif ($search['status'] === 'pending') {
            $search['is_approved'] = false;
            $search['is_denied'] = false;
        }

        // get all request
        $requests = $this->repository->search($limit, $search);

        // render view
        return view('Admin::profile_validation.manage', [
            'requests' => $requests,
            'groups' => $this->getUserGroups(),
            'search' => $search,
        ]);
    }
}
