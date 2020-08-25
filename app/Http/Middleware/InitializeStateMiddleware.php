<?php


namespace App\Http\Middleware;


use App\Models\State;
use Illuminate\Http\Request;

class InitializeStateMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        /** @var State $session */
        $session = app(State::class);
        $session_id = $request->json('apiKey');

        $session->init($session_id);

        return $next($request);
    }
}
