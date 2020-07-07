<?php


namespace App\Daos;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UsersDao extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected static $unguarded = true;

    public function get_user_by_id(string $id): Collection
    {
        return UsersDao::query()
            ->select('*')
            ->where('id', '=', $id)
            ->get();
    }
}
