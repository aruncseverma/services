<?php
/**
 * dashboard index controller
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Dashboard;

use App\Repository\VipMembershipRepository;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    /**
     * handle dashboard request
     *
     * @return Illuminate\Contracts\View\View
     */
    public function handle() : View
    {
        $this->setTitle(__('Dashboard'));

        return view('Admin::dashboard.index', [
            'total' => [
                'escort' => $this->escortRepository->getTotal(),
                'agency' => $this->agencyRepository->getTotal()
            ],
            'new' => [
                'escort' => $this->escortRepository->getNewTotal(),
                'agency' => $this->agencyRepository->getNewTotal()
            ],
            'sales' => $this->getTotalMembershipPlanSales()
        ]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getTotalMembershipPlanSales()
    {
        $repository = app(VipMembershipRepository::class);
        return $repository->getTotalSales();
    }
}
