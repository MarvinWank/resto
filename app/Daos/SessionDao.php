<?php


namespace App\Daos;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SessionDao extends Model
{
    protected $table = "session";
    protected $keyType = "string";
    protected $primaryKey = "id";

    public const PROPERTY_ID = "id";
    public const PROPERTY_DATA = "data";

    public function get_by_id(string $id): ?Model
    {
        try {
            return SessionDao::query()
                ->select('*')
                ->where(self::PROPERTY_ID, '=', $id)
                ->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            return null;
        }
    }
}
