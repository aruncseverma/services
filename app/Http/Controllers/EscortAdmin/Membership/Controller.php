<?php
/**
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\EscortAdmin\Membership;

use App\Repository\BillerRepository;
use App\Repository\MembershipPlanRepository;
use App\Http\Controllers\EscortAdmin\Controller as BaseController;
use App\Repository\VipMembershipRepository;

abstract class Controller extends BaseController 
{
    /**
     * initialize controller and set default repository
     *
     * @param App\Repository\MembershipPlanRepository $repository
     */
    public function __construct(BillerRepository $billerRepo,
                                MembershipPlanRepository $repository,
                                VipMembershipRepository $vipRepo)
    {
        $this->repository = $repository;
        $this->billerRepository = $billerRepo;
        $this->vipRepository = $vipRepo;
        parent::__construct();
    }
}