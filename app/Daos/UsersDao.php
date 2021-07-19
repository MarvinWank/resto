<?php


namespace App\Daos;


use App\Models\Subject;
use App\Value\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class UsersDao extends Model
{
    protected $connection = "mysql";

    const PROPERTY_ID = 'id';
    const PROPERTY_EMAIL = 'email';
    const PROPERTY_NAME = 'name';
    const PROPERTY_PASSWORD = 'password';

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected static $unguarded = true;

    public function validate_auth(string $email, string $password): bool
    {
        $dao_password = UsersDao::query()
            ->select('password')
            ->where(self::PROPERTY_EMAIL, '=', $email)
            ->first()
            ->getAttribute('password');
        return ($dao_password === $password);

    }

    /**
     * @throws \Safe\Exceptions\PasswordException
     */
    public function insert_user(User $user, string $password): int
    {
        return UsersDao::query()->insertGetId([
            self::PROPERTY_NAME => $user->name(),
            self::PROPERTY_EMAIL => $user->email(),
            self::PROPERTY_PASSWORD => \Safe\password_hash($password, 1)
        ]);
    }

    public function getId(): int
    {
        return $this->getAttribute(self::PROPERTY_ID);
    }

    public function getEmail(): string
    {
        return $this->getAttribute(self::PROPERTY_EMAIL);
    }

    public function getName(): string
    {
        return $this->getAttribute(self::PROPERTY_NAME);
    }

    public function getFriends(): Collection
    {
        return $this->belongsToMany(
            UsersDao::class,
            "friends",
            "user_id",
            "friend_id"
        )->getResults();
    }
}
