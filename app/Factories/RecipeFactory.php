<?php


namespace App\Factories;


use App\Daos\RecipeDao;
use App\Models\Recipe;
use App\Models\User;
use App\Value\Cuisine;
use App\Value\DietStyle;

class RecipeFactory
{

    private RecipeDao $recipeDao;

    public function __construct(RecipeDao $recipeDao)
    {
        $this->recipeDao = $recipeDao;
    }

    public function add_recipe
    (
        User $author,
        string $title,
        string $diet_style,
        string $cuisine,
        int $time_to_prepare,
        int $kcal,
        array $ingredients

    ): Recipe
    {
        $diet_style = DietStyle::fromName($diet_style);
        $cuisine = Cuisine::fromName($cuisine);
        $recipe = new Recipe(-1, $title, $author->getID(), $diet_style, $cuisine, $time_to_prepare, $kcal, $ingredients);
        $id = $this->recipeDao->add($recipe);

        return $this->fromId($id);
    }

    public function fromId(int $id): Recipe
    {

    }
}
