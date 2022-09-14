<?php

namespace App\Http\Controllers\EscortAdmin\Bookings;

use App\Http\Controllers\EscortAdmin\Controller as BaseController;
use App\Repository\EscortBookingRepository;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    /**
     * http request variable
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * escort booking repository variable
     *
     * @var App\Repository\EscortBookingRepository
     */
    protected $booking;

    /**
     * default class constructor
     *
     * @param Illuminate\Http\Request                   $request
     * @param App\Repository\EscprtBookingRepository    $booking
     */
    public function __construct(Request $request, EscortBookingRepository $booking)
    {
        $this->request = $request;
        $this->booking = $booking;

        parent::__construct();
    }
}