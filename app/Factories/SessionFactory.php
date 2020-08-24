<?php


namespace App\Factories;


use App\Daos\SessionDao;
use App\Models\Session;
use Faker\Provider\Uuid;

class SessionFactory
{
    /** @var SessionDao $dao */
    private $dao;

    public function __construct(SessionDao $dao)
    {
        $this->dao = $dao;
    }

    public function retrieve(?string $id): Session
    {
        //Erzeuge neue Session
        if ($id === null) {
            $id = Uuid::uuid();
            return new Session($id);
        } // Setze bestehende Session
        else {
            $this->dao = $this->dao->find($id);
            if ($this->dao !== null) {
                return new Session($id);
            }

            $data = $this->dao->getAttribute(SessionDao::PROPERTY_DATA);
            $data = json_decode($data);
            $data = unserialize($data);
            return new Session($id, $data);
        }
    }


    public function save(Session $session): void
    {
        if ($session->dataWasMutated()) {
            $this->dao->setAttribute(SessionDao::PROPERTY_DATA, json_encode($session->getAll()));
            $this->dao->save();
        }
    }
}
