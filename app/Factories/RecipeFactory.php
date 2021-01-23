<?php


namespace App\Factories;


use App\Daos\RecipeDao;
use App\Value\IngredientsSet;
use App\Value\User;
use App\Value\Cuisine;
use App\Value\DietStyle;
use App\Value\Recipe;
use Illuminate\Database\Eloquent\Model;

class RecipeFactory
{

    private RecipeDao $recipeDao;
    private UserFactory $userFactory;

    public function __construct(RecipeDao $recipeDao, UserFactory $userFactory)
    {
        $this->recipeDao = $recipeDao;
        $this->userFactory = $userFactory;
    }

    public function add_recipe
    (
        User $author,
        string $title,
        DietStyle $diet_style,
        Cuisine $cuisine,
        int $time_to_prepare,
        IngredientsSet $ingredients

    ): Recipe
    {
        $recipe = new Recipe(-1, $title, $author, $diet_style, $cuisine, $time_to_prepare, $ingredients);
        $id = $this->recipeDao->add($recipe);

        return $this->fromId($id);
    }

    public function fromId(int $id): Recipe
    {
        /** @var Model $dao_recipe */
        $dao_recipe = $this->recipeDao->find($id);
        return new Recipe(
            $id,
            $dao_recipe->getAttribute(RecipeDao::PROPERTY_TITLE),
            $this->userFactory->from_id($dao_recipe->getAttribute(RecipeDao::PROPERTY_AUTHOR_ID)),
            DietStyle::fromName($dao_recipe->getAttribute(RecipeDao::PROPERTY_DIET_STYLE)),
            Cuisine::fromName($dao_recipe->getAttribute(RecipeDao::PROPERTY_CUISINE)),
            $dao_recipe->getAttribute(RecipeDao::PROPERTY_TIME_TO_PREPARE),
            IngredientsSet::fromArray(\json_decode($dao_recipe->getAttribute(RecipeDao::PROPERTY_INGREDIENTS), true))
        );
    }
}
