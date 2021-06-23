<?php


namespace App\Daos;


use App\Exceptions\RecipeNotFoundException;
use App\Value\Recipe;
use App\Value\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RecipeDao extends Dao
{
    public const PROPERTY_ID = 'id';
    public const PROPERTY_AUTHOR_ID = 'author';
    public const PROPERTY_TITLE = 'title';
    public const PROPERTY_DIET_STYLE = 'dietStyle';
    public const PROPERTY_CUISINE = 'cuisine';
    public const PROPERTY_TYPE_OF_DISH = 'typeOfDish';
    public const PROPERTY_TIME_TO_COOK = 'timeToCook';
    public const PROPERTY_TOTAL_TIME = 'totalTime';
    public const PROPERTY_INGREDIENTS = 'ingredients';
    public const PROPERTY_DESCRIPTION = 'description';

    protected $table = 'recipes';
    protected $primaryKey = 'id';

    /**
     * @throws \Safe\Exceptions\JsonException
     * @throws \Throwable
     */
    public function add(Recipe $recipe): self
    {
        $this->setAttribute(self::PROPERTY_AUTHOR_ID, $recipe->author()->id());
        $this->setAttribute(self::PROPERTY_TITLE, $recipe->title());
        $this->setAttribute(self::PROPERTY_DIET_STYLE, $recipe->dietStyle()->name());
        $this->setAttribute(self::PROPERTY_CUISINE, $recipe->cuisine()->name());
        $this->setAttribute(self::PROPERTY_TYPE_OF_DISH, $recipe->typeOfDish()->name());
        $this->setAttribute(self::PROPERTY_TIME_TO_COOK, $recipe->timeToCook());
        $this->setAttribute(self::PROPERTY_TOTAL_TIME, $recipe->totalTime());
        $this->setAttribute(self::PROPERTY_INGREDIENTS, \Safe\json_encode($recipe->ingredients()->toArray()));
        $this->setAttribute(self::PROPERTY_DESCRIPTION, $recipe->description());

        $this->saveOrFail();

        return $this;
    }

    /**
     * @throws \Throwable
     * @throws RecipeNotFoundException
     */
    public function updateRecipe(Recipe $recipe): self
    {
        $ingredients = \Safe\json_encode($recipe->ingredients()->toArray());

        $this->setAttribute(self::PROPERTY_AUTHOR_ID, $recipe->author()->id());
        $this->setAttribute(self::PROPERTY_TITLE, $recipe->title());
        $this->setAttribute(self::PROPERTY_DIET_STYLE, $recipe->dietStyle()->toString());
        $this->setAttribute(self::PROPERTY_CUISINE, $recipe->cuisine()->toString());
        $this->setAttribute(self::PROPERTY_TYPE_OF_DISH, $recipe->typeOfDish()->name());
        $this->setAttribute(self::PROPERTY_TIME_TO_COOK, $recipe->timeToCook());
        $this->setAttribute(self::PROPERTY_TOTAL_TIME, $recipe->totalTime());
        $this->setAttribute(self::PROPERTY_INGREDIENTS, $ingredients);
        $this->setAttribute(self::PROPERTY_DESCRIPTION, $recipe->description());

        $this->saveOrFail();

        return $this;
    }



}
