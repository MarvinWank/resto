<?php


namespace App\Factories;


use App\Daos\SessionDao;
use App\Models\State;
use Faker\Provider\Uuid;

class StateFactory
{
    /** @var SessionDao $dao */
    private $dao;

    public function __construct(SessionDao $dao)
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

            $data = $this->dao->getAttribute(SessionDao::PROPERTY_DATA);
            $data = json_decode($data);
            $data = unserialize($data);
            return new State($id, $data);
        }
    }


    public function save(State $session): void
    {
        if ($session->dataWasMutated()) {
            $this->dao->setAttribute(SessionDao::PROPERTY_DATA, json_encode($session->getAll()));
            $this->dao->save();
        }
    }
}
