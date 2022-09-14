<?php

namespace App\Http\Middleware;

use Closure;
use App\Support\Concerns\HasNotifications;

class HandleAjax
{
    use HasNotifications;

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($request->ajax()) {
            $data = [];
            $notifications = app('notify')->all();
            if (!empty($notifications)) {
                $data['notifications'] = $notifications;
            }
            $original = $response->original ?? '';
            if (!empty($original)) {
                $data['data'] = $original;
            }
            return response()->json($data, 200);
        }

        return $response;
    }
}
