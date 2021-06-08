<?php


namespace App\Factories;


use App\Daos\RecipeDao;
use App\Exceptions\RecipeNotFoundException;
use App\Value\IngredientsSet;
use App\Value\RecipeSet;
use App\Value\TypeOfDish;
use App\Value\User;
use App\Value\Cuisine;
use App\Value\DietStyle;
use App\Value\Recipe;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RecipeFactory
{

    private RecipeDao $recipeDao;
    private UserFactory $userFactory;

    public function __construct(RecipeDao $recipeDao, UserFactory $userFactory)
    {
        $this->recipeDao = $recipeDao;
        $this->userFactory = $userFactory;
    }

    public function addRecipe
    (
        User $author,
        string $title,
        DietStyle $diet_style,
        Cuisine $cuisine,
        TypeOfDish $type,
        int $timeToCook,
        int $totalTime,
        IngredientsSet $ingredients,
        string $description

    ): Recipe
    {
        $recipe = new Recipe(-1, $title, $author, $diet_style, $cuisine, $type, $timeToCook, $totalTime, $ingredients, $description);
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
        return $this->collectionToSet($results);
    }

    /**
     * @throws RecipeNotFoundException
     * @throws \Safe\Exceptions\JsonException
     */
    public function fromId(int $id): Recipe
    {
        try {
            /** @var Model $daoRecipe */
            $daoRecipe = $this->recipeDao->newQuery()->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            throw RecipeNotFoundException::recipeNotFound($id);
        }

        return new Recipe(
            $id,
            $daoRecipe->getAttribute(RecipeDao::PROPERTY_TITLE),
            $this->userFactory->fromId($daoRecipe->getAttribute(RecipeDao::PROPERTY_AUTHOR_ID)),
            DietStyle::fromName($daoRecipe->getAttribute(RecipeDao::PROPERTY_DIET_STYLE)),
            Cuisine::fromName($daoRecipe->getAttribute(RecipeDao::PROPERTY_CUISINE)),
            TypeOfDish::fromName($daoRecipe->getAttribute(RecipeDao::PROPERTY_TYPE_OF_DISH)),
            $daoRecipe->getAttribute(RecipeDao::PROPERTY_TIME_TO_COOK),
            $daoRecipe->getAttribute(RecipeDao::PROPERTY_TOTAL_TIME),
            IngredientsSet::fromArray(\Safe\json_decode($daoRecipe->getAttribute(RecipeDao::PROPERTY_INGREDIENTS), true)),
            $daoRecipe->getAttribute(RecipeDao::PROPERTY_DESCRIPTION)
        );
    }

    /**
     * @throws Exception
     */
    public function delete(int $id)
    {
        RecipeDao::query()->find($id)->delete();
    }

    /**
     * @throws RecipeNotFoundException
     */
    public function update(Recipe $updatedRecipe, int $id): Recipe
    {
        $this->recipeDao->updateRecipe($updatedRecipe);
        return $this->fromId($id);
    }

    public function getRecipesForSaytSearch(string $searchString, User $user, int $limit): RecipeSet
    {
        $collection = $this->recipeDao->getRecipesForSaytSearch($searchString, $user, $limit);
        return $this->collectionToSet($collection);
    }

    private function collectionToSet(Collection $collection): RecipeSet
    {
        $set = RecipeSet::fromArray([]);
        foreach ($collection->toArray() as $result) {
            $result[RecipeDao::PROPERTY_AUTHOR_ID] = $this->userFactory->fromId($result[RecipeDao::PROPERTY_AUTHOR_ID]);
            $ingredients = \Safe\json_decode($result[RecipeDao::PROPERTY_INGREDIENTS], true);
            $ingredients = IngredientsSet::fromArray($ingredients);
            $result[RecipeDao::PROPERTY_INGREDIENTS] = $ingredients;
            $recipe = Recipe::fromArray($result);
            $set = $set->add($recipe);
        }
        return $set;
    }
}
