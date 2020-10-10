<?php


namespace App\Http\Middleware;

use App\Factories\StateFactory;
use App\Models\State;
use Closure;

class SaveStateMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        /** @var StateFactory $stateFactory */
        $stateFactory = app(StateFactory::class);
        /** @var State $state */
        $state = app(State::class);
        $stateFactory->save($state);

        return $response;
    }
}
