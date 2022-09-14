<?php
/**
 * base controller class for namespace Rate Durations
 *
 * @abstract
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\RateDurations;

use App\Repository\RateDurationRepository;
use App\Repository\RateDurationDescriptionRepository;
use App\Http\Controllers\Admin\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * rate duration repository instance
     *
     * @var App\Repository\RateDurationRepository
     */
    protected $durationRepository;

    /**
     * rate duration description repository instance
     *
     * @var App\Repository\RateDurationDescriptionRepository
     */
    protected $descriptionRepository;

    /**
     * create instance
     *
     * @param App\Repository\RateDurationRepository; $repository
     */
    public function __construct(RateDurationRepository $durationRepository, RateDurationDescriptionRepository $descriptionRepository)
    {
        $this->durationRepository = $durationRepository;
        $this->descriptionRepository = $descriptionRepository;

        parent::__construct();
    }
}
