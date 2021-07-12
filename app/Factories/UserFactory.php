<?php


namespace App\Factories;


use App\Daos\FriendshipDao;
use App\Daos\UsersDao;
use App\Exceptions\SaveException;
use App\Models\State;
use App\Value\IntegerSet;
use App\Value\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserFactory
{
    private State $state;

    public function __construct(State $state)
    {
        $this->state = $state;
    }

    public function currentUser(): User
    {
        return $this->fromId($this->state->getUserID());
    }

    /** @throws ModelNotFoundException */
    public function fromId(int $id): User
    {
        $userDao = new UsersDao();
        $dao = $userDao->findOrFail($id);
        return $this->fromDao($dao);
    }

    //TODO better exception Handling
    public function fromAuth(string $email, string $password): ?User
    {
        $dao = new UsersDao();
        try {
            $dao_user = $dao->where(UsersDao::PROPERTY_EMAIL, '=', $email);
            $dao_user = $dao_user->firstOrFail();
        } catch (\Throwable $exception) {
            //Email existiert nicht
            return null;
        }
        //Passwort war falsch
        if (!$dao->validate_auth($email, $password)) {
            return null;
        }

        $user = $this->fromDao($dao_user);
        $this->state->setUserID($user->id());

        return $user;
    }

    /**
     * @throws \Throwable
     */
    public function addUser(string $name, string $email, string $pasword): User
    {
        $usersDao = new UsersDao();
        $usersDao->setAttribute(UsersDao::PROPERTY_NAME, $name);
        $usersDao->setAttribute(UsersDao::PROPERTY_EMAIL, $email);
        $usersDao->setAttribute(UsersDao::PROPERTY_PASSWORD, $pasword);

        $usersDao->saveOrFail();
        return $this->fromDao($usersDao);
    }

    /**
     * @throws SaveException
     */
    public function addFriendToUser(User $user, User $friend)
    {
        $friendshipDao = new FriendshipDao();
        $friendshipDao->setAttribute(FriendshipDao::PROPERTY_USER_ID, $user->id());
        $friendshipDao->setAttribute(FriendshipDao::PROPERTY_FRIEND_ID, $friend->id());

        try {
            $friendshipDao->saveOrFail();
        } catch (\Throwable $e) {
            throw SaveException::failedSavingModel($friendshipDao, $e);
        }
    }

    private function fromDao(UsersDao $dao_user): User
    {
        $id = $dao_user->getAttribute(UsersDao::PROPERTY_ID);
        $email = $dao_user->getAttribute(UsersDao::PROPERTY_EMAIL);
        $name = $dao_user->getAttribute(UsersDao::PROPERTY_NAME);
        $friendsSet = IntegerSet::fromArray($dao_user->getFriends()->toArray());

        return new User($id, $name, $email, $friendsSet);
    }
}
