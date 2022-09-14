<?php
/**
 * handles read status for notifications
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\EscortAdmin\Notifications;

use App\Http\Controllers\EscortAdmin\Controller;
use Illuminate\Http\Request;

class MarkAsReadController extends Controller
{
    /**
     * handles setting notification as read
     *
     * @param Request $request
     * @return void
     */
    public function handle(Request $request)
    {
        $id = $request->id;
        $notification = $this->getAuthUser()->notifications()->where('id', $id)->first();
        $notification->markAsRead();
    }
}