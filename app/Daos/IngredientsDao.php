<?php


namespace App\Daos;


use Illuminate\Database\Eloquent\Model;

class IngredientsDao extends Model
{
    protected $table = "ingredients";
    protected $primaryKey = self::PROPERTY_ID;

    public $timestamps = false;

    public const PROPERTY_ID = 'id';
    public const PROPERTY_NAME = "name";
    public const PROPERTY_KCAL = "kcal";

    protected $fillable = [self::PROPERTY_ID, self::PROPERTY_NAME, self::PROPERTY_KCAL];

    public function insert(array $values)
    {
        IngredientsDao::query()->insert($values);
    }
}
