<?php


namespace App\Factories;


use App\Daos\StateDao;
use App\Models\State;
use Faker\Provider\Uuid;

class StateFactory
{
    private StateDao $dao;

    public function __construct(StateDao $dao)
    {
        $this->dao = $dao;
    }

    public function retrieve(?string $id): State
    {
        //Erzeuge neue State
        if ($id === null) {
            $id = Uuid::uuid();
            $this->dao = new StateDao;
            $this->dao->setAttribute(StateDao::PROPERTY_ID, $id);

            return new State($id);
        } // Setze bestehende State
        else {
            $this->dao = $this->dao->find($id);
            if ($this->dao === null) {
                $this->dao = new StateDao;
                $this->dao->setAttribute(StateDao::PROPERTY_ID, $id);
                return new State($id);
            }

            $state = new State($id);
            $userID = $this->dao->getAttribute(StateDao::PROPERTY_USER_ID);
            $state->setUserID($userID);

            return $state;
        }
    }


    public function save(State $state): void
    {
        if ($state->dataWasMutated()) {
            $this->dao->setAttribute(StateDao::PROPERTY_USER_ID, $state->getUserID()->getID());
            $this->dao->save();
        }
    }
}
