<?php


namespace App\Http\Middleware;

use App\Models\State;
use Closure;

class SaveSessionMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $session = app(State::class);
        $session->save();

        return $response;
    }
}
