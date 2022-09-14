<?php
/**
 * event triggered when updating status of a language
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Events\Admin\Languages;

use App\Models\Language;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UpdatingStatus
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * language model instance
     *
     * @var App\Models\Language
     */
    public $language;

    /**
     * Create a new event instance.
     *
     * @param  App\Models\Language $language
     *
     * @return void
     */
    public function __construct(Language $language)
    {
        $this->language = $language;
    }
}
