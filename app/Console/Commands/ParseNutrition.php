<?php

namespace App\Console\Commands;


use App\Daos\IngredientsDao;
use App\Daos\StateDao;
use Illuminate\Console\Command;

class ParseNutrition extends Command
{

    private const FILE_PATH = "./dokumentation/nutrition_table.json";
    private IngredientsDao $dao;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse_nutrition';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Liest Nährwerte aus Nährwertabelle ein';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(IngredientsDao $dao)
    {
        parent::__construct();
        $this->dao = $dao;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = file_get_contents(self::FILE_PATH);
        $content = json_decode($file);
        $parsed_values = [];

        foreach ($content as $raw_line) {
            $parsed_value[IngredientsDao::PROPERTY_NAME] = $raw_line->Name;
            $parsed_value[IngredientsDao::PROPERTY_KCAL] = $raw_line->kcal;

            $parsed_values[] = $parsed_value;
        }

        $this->dao->insert($parsed_values);

        return 0;
    }
}
