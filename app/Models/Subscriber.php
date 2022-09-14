<?php
/**
 * Newsletter Subscribers model
 *
 * @author Jhay Bagas <jhay@circus.ac>
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{

    protected $table = "newsletter_subscribers";

    protected $fillable = [
        'email',
        'is_subscribed'
    ];
}
