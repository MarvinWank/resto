<?php

use App\Value\Ingredient;
use App\Value\IngredientsSet;
use App\Value\SIUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use function Safe\json_encode;

class RecipeSeeder extends Seeder
{
    public function run()
    {
        $ingredients = IngredientsSet::fromArray([
            new Ingredient("Butter", 200, SIUnit::g(), 100),
            new Ingredient("Schmalz", 200, SIUnit::g(), 100),
            new Ingredient("Milch", 200, SIUnit::g(), 100),
            new Ingredient("Mehl", 200, SIUnit::g(), 100),
        ]);

        DB::table('recipes')
            ->insert([
                "author" => 2,
                "title" => "Ofenkartoffeln",
                "dietStyle" => \App\Value\DietStyle::VEGAN()->name(),
                "cuisine" => \App\Value\Cuisine::DEUTSCH()->name(),
                "timeToCook" => "20",
                "totalTime" => "80",
                "ingredients" => json_encode($ingredients->toArray()),
                "description" => "safsioadfhsaiofhsaiofh"
            ]);
    }
}
