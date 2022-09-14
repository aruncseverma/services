<?php
/**
 * event triggered for updating city status
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */
namespace App\Events\Admin\Locations;

use App\Models\City;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UpdatingStatus
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * city model instance
     *
     * @var App\Models\Language
     */
    public $city;

    /**
     * Create a new event instance.
     *
     * @param  App\Models\City $city
     *
     * @return void
     */
    public function __construct(City $city)
    {
        $this->city = $city;
    }
}
