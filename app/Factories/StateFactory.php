<?php


namespace App\Factories;


use App\Daos\StateDao;
use App\Models\State;
use Faker\Provider\Uuid;

class StateFactory
{
    /** @var StateDao $dao */
    private $dao;

    public function __construct(StateDao $dao)
    {
        $this->dao = $dao;
    }

    public function retrieve(?string $id): State
    {
        //Erzeuge neue State
        if ($id === null) {
            $id = Uuid::uuid();
            return new State($id);
        } // Setze bestehende State
        else {
            $this->dao = $this->dao->find($id);
            if ($this->dao !== null) {
                return new State($id);
            }

            $data = $this->dao->getAttribute(StateDao::PROPERTY_DATA);
            $data = json_decode($data);
            return new State($id);
        }
    }


    public function save(State $session): void
    {
        if ($session->dataWasMutated()) {
            $this->dao->setAttribute(StateDao::PROPERTY_DATA, json_encode($session->getAll()));
            $this->dao->save();
        }
    }
}
