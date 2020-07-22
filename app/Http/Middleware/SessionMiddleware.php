<?php


namespace App\Http\Middleware;

use App\Models\Session;
use Closure;

class SessionMiddleware
{
    public function handle($request, Closure $next, Session $session)
    {
        $response = $next($request);

        $session->save();

        return $response;
    }
}
