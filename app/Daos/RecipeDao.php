<?php


namespace App\Daos;


use App\Value\Recipe;
use App\Value\User;
use Illuminate\Database\Eloquent\Model;

class RecipeDao extends Model
{
    public const PROPERTY_ID = 'id';
    public const PROPERTY_AUTHOR_ID = 'author';
    public const PROPERTY_TITLE = 'title';
    public const PROPERTY_DIET_STYLE = 'dietStyle';
    public const PROPERTY_CUISINE = 'cuisine';
    public const PROPERTY_TIME_TO_COOK = 'timeToCook';
    public const PROPERTY_TOTAL_TIME = 'totalTime';
    public const PROPERTY_KCAL = 'kcal';
    public const PROPERTY_INGREDIENTS = 'ingredients';

    protected $table = 'recipes';
    protected $primaryKey = 'id';

    public function add(Recipe $recipe): int
    {
        return $this->newQuery()->insertGetId([
            self::PROPERTY_AUTHOR_ID => $recipe->author()->id(),
            self::PROPERTY_TITLE => $recipe->title(),
            self::PROPERTY_DIET_STYLE => $recipe->dietStyle()->name(),
            self::PROPERTY_CUISINE => $recipe->cuisine()->name(),
            self::PROPERTY_TIME_TO_COOK => $recipe->timeToCook(),
            self::PROPERTY_TOTAL_TIME => $recipe->totalTime(),
            self::PROPERTY_INGREDIENTS => json_encode($recipe->ingredients()->toArray())
        ]);
    }

    public function deleteForUser(User $user)
    {
        $this->newQuery()
            ->where(self::PROPERTY_AUTHOR_ID, "=", $user->id())
            ->delete();
    }

    public function getForUser(User $user)
    {
        return $this->newQuery()
            ->where(self::PROPERTY_AUTHOR_ID, '=', $user->id())
            ->get();
    }
}
