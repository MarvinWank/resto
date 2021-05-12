<?php


namespace App\Factories;


use App\Daos\StateDao;
use App\Models\State;
use Ramsey\Uuid\Uuid;

class StateFactory
{
    private ?StateDao $dao;

    public function __construct(StateDao $dao)
    {
        $this->dao = $dao;
    }

    public function retrieve(?string $id): State
    {
        //Erzeuge neue State
        if ($id === null || $id === "") {
            $id = Uuid::uuid4();
            $this->dao = new StateDao;
            $this->dao->setAttribute(StateDao::PROPERTY_ID, $id->toString());

            return new State($id);
        } // Setze bestehende State
        else {
            if ($this->dao->newQuery()->find($id) === null) {
                $this->dao = new StateDao;
                $state = new State($id);
                return $state;
            } else {
                $this->dao = $this->dao->newQuery()->find($id);
                $state = new State($id);
                $userID = $this->dao->getAttribute(StateDao::PROPERTY_USER_ID);
                $state->setUserID($userID);
                return $state;
            }
        }
    }

    public function save(State $state): void
    {
        if ($state->dataWasMutated()) {
            $this->dao->setAttribute(StateDao::PROPERTY_ID, $state->getStateId());
            $this->dao->setAttribute(StateDao::PROPERTY_USER_ID, $state->getUserID());
            $this->dao->save();
        }
    }

    public function is_key_valid(string $key_to_check): bool
    {
        $key = $this->dao->newQuery()->find($key_to_check);
        if ($key === null) {
            return false;
        }

        return true;
    }
}
