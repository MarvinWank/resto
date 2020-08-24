<?php


namespace App\Providers;


use App\Factories\SessionFactory;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class SessionServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->app->singleton('App\Models\Session', function ($app) {

            /** @var Request $request */
            $request = app(Request::class);
            /** @var SessionFactory $sessionFactory */
            $sessionFactory = app(SessionFactory::class);

            return $sessionFactory->retrieve($request->post('apiKey'));
        });
    }
}
