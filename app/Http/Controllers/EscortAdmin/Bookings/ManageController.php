<?php
/**
 * booking listing
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\EscortAdmin\Bookings;

class ManageController extends Controller
{

    public function index()
    {
        $user = $this->getAuthUser();
        $search = $this->request->query();
        $search['object_id'] = $user->getKey();

        $limit  = $this->getPageSize();
        $search = array_merge(
            [
                'limit' => $limit,
            ],
            $search
        );

        // set title
        $this->setTitle(__('Bookings'));

        // fetch all booking database
        $bookings = $this->booking->search($limit, $search);

        return view('EscortAdmin::bookings.index', [
            'bookings' => $bookings
        ]);
    }
}