<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;

class ServeFrontend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:frontend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setzt frontend dev-server auf';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      return  exec('cd frontend; npm run serve src/main.ts');
    }
}
