<?php


namespace App\Daos;


use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UsersDao extends Model
{
    const PROPERTY_ID = 'id';
    const PROPERTY_EMAIL = 'email';
    const PROPERTY_NAME = 'name';
    const PROPERTY_PASSWORD = 'password';

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected static $unguarded = true;

    public function get_user_by_id(string $id): Collection
    {
        return UsersDao::query()
            ->select('*')
            ->where(self::PROPERTY_ID, '=', $id)
            ->get();
    }

    public function insert_user(User $user, string $password): int
    {
        return UsersDao::query()->insertGetId([
            self::PROPERTY_NAME => $user->get_name(),
            self::PROPERTY_EMAIL => $user->get_email(),
            self::PROPERTY_PASSWORD => password_hash($password, 1)
        ]);
    }
}
