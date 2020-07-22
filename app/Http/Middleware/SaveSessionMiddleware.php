<?php


namespace App\Http\Middleware;

use App\Models\Session;
use Closure;

class SaveSessionMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $session = app(Session::class);
        $session->save();

        return $response;
    }
}
