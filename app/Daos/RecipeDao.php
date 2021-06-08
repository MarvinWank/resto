<?php


namespace App\Daos;


use App\Exceptions\RecipeNotFoundException;
use App\Value\Recipe;
use App\Value\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RecipeDao extends Model
{
    public const PROPERTY_ID = 'id';
    public const PROPERTY_AUTHOR_ID = 'author';
    public const PROPERTY_TITLE = 'title';
    public const PROPERTY_DIET_STYLE = 'dietStyle';
    public const PROPERTY_CUISINE = 'cuisine';
    public const PROPERTY_TYPE_OF_DISH = 'type_of_dish';
    public const PROPERTY_TIME_TO_COOK = 'timeToCook';
    public const PROPERTY_TOTAL_TIME = 'totalTime';
    public const PROPERTY_INGREDIENTS = 'ingredients';
    public const PROPERTY_DESCRIPTION = 'description';

    protected $table = 'recipes';
    protected $primaryKey = 'id';

    /**
     * @throws \Safe\Exceptions\JsonException
     */
    public function add(Recipe $recipe): int
    {
        return $this->newQuery()->insertGetId([
            self::PROPERTY_AUTHOR_ID => $recipe->author()->id(),
            self::PROPERTY_TITLE => $recipe->title(),
            self::PROPERTY_DIET_STYLE => $recipe->dietStyle()->name(),
            self::PROPERTY_CUISINE => $recipe->cuisine()->name(),
            self::PROPERTY_TYPE_OF_DISH => $recipe->typeOfDish()->name(),
            self::PROPERTY_TIME_TO_COOK => $recipe->timeToCook(),
            self::PROPERTY_TOTAL_TIME => $recipe->totalTime(),
            self::PROPERTY_INGREDIENTS => \Safe\json_encode($recipe->ingredients()->toArray()),
            self::PROPERTY_DESCRIPTION => $recipe->description()
        ]);
    }

    public function deleteForUser(User $user)
    {
        $this->newQuery()
            ->where(self::PROPERTY_AUTHOR_ID, "=", $user->id())
            ->delete();
    }

    public function getForUser(User $user): Collection
    {
        return $this->newQuery()
            ->where(self::PROPERTY_AUTHOR_ID, '=', $user->id())
            ->get();
    }

    public function getTopRecipesForUser(User $user, int $limit = -1): Collection
    {
        $query = $this->newQuery();
        $query = $this->onlyGetAllowedRecipesForUser($query, $user);
        if ($limit !== -1) {
            $query->limit($limit);
        }

        return $query->get();
    }

    public function updateRecipe(Recipe $recipe)
    {
        try {
            $currentRecipe = $this->newQuery()->findOrFail($recipe->id());
        } catch (ModelNotFoundException $exception) {
            throw RecipeNotFoundException::recipeNotFound($recipe->id());
        }

        $currentRecipe->setAttribute(self::PROPERTY_AUTHOR_ID, $recipe->author()->id());
        $currentRecipe->setAttribute(self::PROPERTY_TITLE, $recipe->title());
        $currentRecipe->setAttribute(self::PROPERTY_DIET_STYLE, $recipe->dietStyle()->toString());
        $currentRecipe->setAttribute(self::PROPERTY_CUISINE, $recipe->cuisine()->toString());
        $currentRecipe->setAttribute(self::PROPERTY_TYPE_OF_DISH, $recipe->typeOfDish()->name());
        $currentRecipe->setAttribute(self::PROPERTY_TIME_TO_COOK, $recipe->timeToCook());
        $currentRecipe->setAttribute(self::PROPERTY_TOTAL_TIME, $recipe->totalTime());
        $currentRecipe->setAttribute(self::PROPERTY_INGREDIENTS, $recipe->ingredients()->toArray());
        $currentRecipe->setAttribute(self::PROPERTY_DESCRIPTION, $recipe->description());

        $currentRecipe->save();
    }

    public function getRecipesForSaytSearch(string $searchString, User $user, int $limit): Collection
    {
        $query = $this->newQuery();
        $query = $this->onlyGetAllowedRecipesForUser($query, $user);
        return $query
            ->where(self::PROPERTY_TITLE, 'LIKE', "%" . $searchString . "%")
            ->limit($limit)
            ->get();
    }

    private function onlyGetAllowedRecipesForUser(Builder $query, User $user): Builder
    {
        //TODO this is incomplete
        return $query
            ->where(self::PROPERTY_AUTHOR_ID, "=", $user->id());
    }
}
