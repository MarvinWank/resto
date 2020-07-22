<?php


namespace App\Http\Middleware;


use App\Models\Session;
use Illuminate\Http\Request;

class InitializeSessionMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        /** @var Session $session */
        $session = app(Session::class);
        $session_id = $request->json('apiKey');

        $session->init($session_id);

        return $next($request);
    }
}
