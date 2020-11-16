<?php


namespace App\Daos;


use App\Models\Recipe;
use Illuminate\Database\Eloquent\Model;

class RecipeDao extends Model
{
    public const PROPERTY_ID = 'id';
    public const PROPERTY_AUTHOR_ID = 'author';
    public const PROPERTY_TITLE = 'title';
    public const PROPERTY_DIET_STYLE = 'diet_style';
    public const PROPERTY_CUISINE = 'cuisine';
    public const PROPERTY_TIME_TO_PREPARE = 'time_to_prepare';
    public const PROPERTY_KCAL = 'kcal';
    public const PROPERTY_INGREDIENTS = 'ingredients';

    protected $table = 'recipes';
    protected $primaryKey = 'id';

    public function add(Recipe $recipe): int
    {
       return $this->newQuery()->insertGetId([
            self::PROPERTY_AUTHOR_ID => $recipe->getAuthor()->getID(),
            self::PROPERTY_TITLE => $recipe->getTitle(),
            self::PROPERTY_DIET_STYLE => $recipe->getDietStyle()->name(),
            self::PROPERTY_CUISINE => $recipe->getCuisine()->name(),
            self::PROPERTY_TIME_TO_PREPARE => $recipe->getTimeToPrepare(),
            self::PROPERTY_KCAL => $recipe->getKcal(),
            self::PROPERTY_INGREDIENTS => json_encode($recipe->getIngredients())
        ]);
    }
}
