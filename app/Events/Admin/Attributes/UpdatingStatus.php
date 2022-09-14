<?php
/**
 * event triggered when updating attribute status
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Events\Admin\Attributes;

use App\Models\Attribute;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UpdatingStatus
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * attribute model instance
     *
     * @var App\Models\Attribute
     */
    public $attribute;

    /**
     * Create a new event instance.
     *
     * @param  App\Models\Attribute $attribute
     *
     * @return void
     */
    public function __construct(Attribute $attribute)
    {
        $this->attribute = $attribute;
    }
}
