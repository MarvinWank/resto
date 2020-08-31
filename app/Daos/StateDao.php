<?php


namespace App\Daos;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StateDao extends Model
{
    protected $table = "session";
    protected $keyType = "string";
    protected $primaryKey = self::PROPERTY_ID;

    public $timestamps = false;

    public const PROPERTY_ID = "stateID";
    public const PROPERTY_USER_ID = "userID";

    protected $attributes = [self::PROPERTY_ID, self::PROPERTY_USER_ID];

}
