<?php


namespace App\Factories;


use App\Daos\RecipeDao;
use App\Value\IngredientsSet;
use App\Value\RecipeSet;
use App\Value\User;
use App\Value\Cuisine;
use App\Value\DietStyle;
use App\Value\Recipe;
use Illuminate\Database\Eloquent\Collection;
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
        int $timeToCook,
        int $totalTime,
        IngredientsSet $ingredients

    ): Recipe
    {
        $recipe = new Recipe(-1, $title, $author, $diet_style, $cuisine, $timeToCook, $totalTime, $ingredients);
        $id = $this->recipeDao->add($recipe);

        return $this->fromId($id);
    }

    public function getAllRecipesForUser(User $user): RecipeSet
    {
        $results = $this->recipeDao->getForUser($user);
        return $this->collectionToSet($results);
    }

    public function getTopRecipesForUser(User $user, int $limit = 3): RecipeSet
    {
        $results = $this->recipeDao->getTopRecipesForUser($user, $limit);
        return  $this->collectionToSet($results);
    }


    public function fromId(int $id): Recipe
    {
        /** @var Model $dao_recipe */
        $dao_recipe = $this->recipeDao->newQuery()->find($id);
        return new Recipe(
            $id,
            $dao_recipe->getAttribute(RecipeDao::PROPERTY_TITLE),
            $this->userFactory->from_id($dao_recipe->getAttribute(RecipeDao::PROPERTY_AUTHOR_ID)),
            DietStyle::fromName($dao_recipe->getAttribute(RecipeDao::PROPERTY_DIET_STYLE)),
            Cuisine::fromName($dao_recipe->getAttribute(RecipeDao::PROPERTY_CUISINE)),
            $dao_recipe->getAttribute(RecipeDao::PROPERTY_TIME_TO_COOK),
            $dao_recipe->getAttribute(RecipeDao::PROPERTY_TOTAL_TIME),
            IngredientsSet::fromArray(\json_decode($dao_recipe->getAttribute(RecipeDao::PROPERTY_INGREDIENTS), true))
        );
    }

    private function collectionToSet(Collection $collection): RecipeSet
    {
        $set = RecipeSet::fromArray([]);
        foreach ($collection->toArray() as $result) {
            $result[RecipeDao::PROPERTY_AUTHOR_ID] = $this->userFactory->from_id($result[RecipeDao::PROPERTY_AUTHOR_ID]);
            $ingredients = json_decode($result[RecipeDao::PROPERTY_INGREDIENTS], true);
            $ingredients = IngredientsSet::fromArray($ingredients);
            $result[RecipeDao::PROPERTY_INGREDIENTS] = $ingredients;
            $recipe = Recipe::fromArray($result);
            $set = $set->add($recipe);
        }
        return $set;
    }
}
