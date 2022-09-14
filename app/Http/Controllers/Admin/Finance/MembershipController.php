<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Repository\MembershipPlanRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MembershipController extends Controller
{
    /**
     * repository instance
     *
     * @var App\Repository\MembershipPlanRepository
     */
    protected $repository;

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware() : void
    {
        $this->middleware('can:general_settings.manage');
    }

    /**
     * view site transactions form
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index(MembershipPlanRepository $repository) : View
    {
        $this->setTitle(__('Membership Plans'));

        $limit = $this->getPageSize();
        $search = array_merge(
            [
                'limit' => $limit,
                'is_active' => '*',
                'currency' => '*'
            ],
            $this->request->query()
        );
        $plans = $repository->search($limit, $search);

        return view('Admin::finance.membership', [
            'search' => $search,
            'plans' => $plans
        ]);
    }

    /**
     * Undocumented function
     *
     * @param MembershipPlanRepository $repository
     * @return View
     */
    public function new(MembershipPlanRepository $repository) : View
    {
        // get biller info
        $plan = $repository->new();
        $plan->is_active = 1;

        // create view instance
        return view('Admin::finance.editplan', [
            'plan' => $plan,
        ]);
    }

    public function save(MembershipPlanRepository $repository) : RedirectResponse
    {
        $limit = $this->getPageSize();
        $search = array_merge(
            [
                'limit' => $limit,
                'is_active' => '*',
                'currency' => '*'
            ],
            $this->request->query()
        );

        $plan = $repository->find($this->request->input('id'));

        $attributes = [
            'currency_id'       => $this->request->input('currency'),
            'months'            => $this->request->input('months'),
            'discount'          => $this->request->input('discount'),
            'total_price'       => $this->request->input('total_price'),
            'price_per_month'   => $this->request->input('price_per_month'),
            'is_active'         => $this->request->input('is_active')
        ];

        $repository->save($attributes, $plan);

        return redirect()->route('admin.finance.plans', $search);
    }

    /**
     * edit package
     *
     * @return Illuminate\Contracts\View\View
     */
    public function edit(MembershipPlanRepository $repository) : View
    {
        // get biller info
        $plan = $repository->find($this->request->get('id'));

        // create view instance
        return view('Admin::finance.editplan', [
            'plan' => $plan,
        ]);
    }
}