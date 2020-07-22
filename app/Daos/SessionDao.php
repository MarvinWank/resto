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
}
