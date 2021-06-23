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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Safe\Exceptions\JsonException;

class RecipeFactory
{

    private UserFactory $userFactory;

    public function __construct(UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
    }

    /**
     * @throws \Throwable
     * @throws JsonException
     */
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
        $dao = new RecipeDao();
        $dao = $dao->add($recipe);

        return $this->fromDao($dao);
    }

    public function getAllRecipesForUser(User $user): RecipeSet
    {
        $dao = new RecipeDao();
        $results = $dao->where(RecipeDao::PROPERTY_AUTHOR_ID, '=',$user->id())->get();
        return $this->collectionToSet($results);
    }

    public function getTopRecipesForUser(User $user, int $limit = 3): RecipeSet
    {
        $dao = new RecipeDao();
        $results = $dao->where(RecipeDao::PROPERTY_AUTHOR_ID, '=',$user->id())
            ->limit($limit)
            ->get()
        ;
        return $this->collectionToSet($results);
    }

    /**
     * @throws JsonException
     */
    public function fromDao(RecipeDao $dao): Recipe
    {
        $ingredients = IngredientsSet::fromArray(
            \Safe\json_decode($dao->getAttribute(RecipeDao::PROPERTY_INGREDIENTS), true)
        );
        return new Recipe(
            $dao->getAttribute(RecipeDao::PROPERTY_ID),
            $dao->getAttribute(RecipeDao::PROPERTY_TITLE),
            $this->userFactory->fromId($dao->getAttribute(RecipeDao::PROPERTY_AUTHOR_ID)),
            DietStyle::fromName($dao->getAttribute(RecipeDao::PROPERTY_DIET_STYLE)),
            Cuisine::fromName($dao->getAttribute(RecipeDao::PROPERTY_CUISINE)),
            TypeOfDish::fromName($dao->getAttribute(RecipeDao::PROPERTY_TYPE_OF_DISH)),
            $dao->getAttribute(RecipeDao::PROPERTY_TIME_TO_COOK),
            $dao->getAttribute(RecipeDao::PROPERTY_TOTAL_TIME),
            $ingredients,
            $dao->getAttribute(RecipeDao::PROPERTY_DESCRIPTION)
        );
    }

    /**
     * @throws RecipeNotFoundException
     * @throws JsonException
     */
    public function fromId(int $id): Recipe
    {
        try {
            $dao = new RecipeDao();
            $dao = $dao->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            throw RecipeNotFoundException::recipeNotFound($id);
        }

        return $this->fromDao($dao);
    }

    /**
     * @throws Exception
     */
    public function delete(int $id)
    {
        $dao = new RecipeDao();
        $dao->findOrFail($id)->delete();
    }

    public function deleteForUser(User $user)
    {
        $dao = new RecipeDao();
        $results = $dao->where(RecipeDao::PROPERTY_AUTHOR_ID, '=', $user->id())->delete();
    }

    /**
     * @throws RecipeNotFoundException
     */
    public function update(Recipe $updatedRecipe, int $id): Recipe
    {
        $dao = new RecipeDao();
        $dao = $dao->findOrFail($id);
        $dao = $dao->updateRecipe($updatedRecipe);

        return $this->fromDao($dao);
    }

    public function getRecipesForSaytSearch(string $searchString, User $user, int $limit = 5): RecipeSet
    {
        $dao = new RecipeDao();
        $query = $dao->newQuery();
        $query = $this->onlyGetAllowedRecipesForUser($query, $user);
        $results =  $query
            ->where(RecipeDao::PROPERTY_TITLE, 'LIKE', "%" . $searchString . "%")
            ->limit($limit)
            ->get();

        return $this->collectionToSet($results);
    }

    private function onlyGetAllowedRecipesForUser(Builder $query, User $user): Builder
    {
        //TODO this is incomplete
        return $query
            ->where(RecipeDao::PROPERTY_AUTHOR_ID, "=", $user->id());
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
