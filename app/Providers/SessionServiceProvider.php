<?php


namespace App\Providers;


use App\Factories\StateFactory;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class SessionServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->app->singleton('App\Models\State', function ($app) {

            /** @var Request $request */
            $request = app(Request::class);
            /** @var StateFactory $sessionFactory */
            $sessionFactory = app(StateFactory::class);

            return $sessionFactory->retrieve($request->post('apiKey'));
        });
    }
}
