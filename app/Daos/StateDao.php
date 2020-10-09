<?php


namespace App\Daos;


use App\Models\State;
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

//    protected $attributes = [self::PROPERTY_ID, self::PROPERTY_USER_ID];
    protected $fillable = [self::PROPERTY_ID, self::PROPERTY_USER_ID];

    public function insert(State $state): int
    {
        return StateDao::query()
            ->insertGetId([
                self::PROPERTY_ID => $state->getStateId(),
                self::PROPERTY_USER_ID => $state->getUserID()
            ]);
    }

}
