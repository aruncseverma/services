<?php

namespace App\Events\Repository\Settings;

use App\Models\Setting;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class SavedModelInstance
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * instance of a eloquent model
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * event array of attributes
     *
     * @var array
     */
    public $attributes;

    /**
     * Create a new event instance.
     *
     * @param  App\Models\Setting $setting
     * @param  array              $attributes
     *
     * @return void
     */
    public function __construct(Setting $setting, array $attributes)
    {
        $this->setting = $setting;
        $this->attributes = $attributes;
    }
}
