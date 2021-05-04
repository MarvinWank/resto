<?php


namespace App\Daos;


use Illuminate\Database\Eloquent\Model;

class ShoppingListDao extends Model
{
    protected $table = \CreateTableShoppingLists::TABLE_NAME;
    protected $primaryKey = self::PROPERTY_ID;

    public $timestamps = false;

    public const PROPERTY_ID = "id";
    public const PROPERTY_USER_ID = "user_id";
    public const PROPERTY_INGREDIENTS = "ingredients";

    protected $fillable = [self::PROPERTY_ID, self::PROPERTY_USER_ID, self::PROPERTY_INGREDIENTS];
}
