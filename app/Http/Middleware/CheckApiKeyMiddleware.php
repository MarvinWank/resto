<?php


namespace App\Http\Middleware;


use App\Factories\StateFactory;
use Closure;
use Illuminate\Http\Request;

class CheckApiKeyMiddleware implements Middleware
{
    private StateFactory $stateFactory;

    public function __construct(StateFactory $stateFactory)
    {
        $this->stateFactory = $stateFactory;
    }

    public function handle(Request $request, Closure $next)
    {
        $api_key = $request->json()->get('apiKey');

        if (!$this->stateFactory->is_key_valid($api_key)) {
            return response()->json([
               "status" => "error",
               "message" => "apiKey ungueltig"
            ]);
        }

        return $next($request);
    }
}
