<?php


namespace App\Daos;


use Illuminate\Database\Eloquent\Model;

class RecipeDao extends Model
{
    public const PROPERTY_ID = 'id';
    public const AUTHOR_ID = 'author';
    public const TYPE_OF_MEAL = 'type_of_meal';
    public const CUISINE = 'cuisine';
    public const TIME_TO_PREPARE = 'time_to_prepare';
    public const KCAL = 'kcal';
    public const INGREDIENTS = 'ingredients';

    protected $table = 'recipes';
    protected $primaryKey = 'id';
}
