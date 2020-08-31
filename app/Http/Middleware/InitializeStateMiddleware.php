<?php


namespace App\Http\Middleware;


use App\Models\State;
use Illuminate\Http\Request;

class InitializeStateMiddleware
{
    public function handle( $request, \Closure $next)
    {
        /** @var State $state */
        $state = app(State::class);
        $stateID = $request->json('apiKey');

        $state->init($stateID);

        return $next($request);
    }
}
