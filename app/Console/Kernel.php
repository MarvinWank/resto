<?php

namespace App\Console;

use App\Console\Commands\ParseNutrition;
use App\Console\Commands\ServeBackend;
use App\Console\Commands\ServeFrontend;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ServeFrontend::class,
        ServeBackend::class,
        ParseNutrition::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
