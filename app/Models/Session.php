<?php


namespace App\Models;

use App\Daos\SessionDao;
use Faker\Provider\Uuid;

class Session
{
    /** @var string $id */
    private $id;
    /** @var array $storage */
    private $storage;
    /** @var SessionDao $dao */
    private $dao;
    /** @var bool $data_was_mutated */
    private $data_was_mutated = false;

    public function __construct(SessionDao $dao)
    {
        $this->id = Uuid::uuid();
        $this->dao = $dao;

        //Session ist schon vorhanden
        if($this->dao->find($this->id)!== null){
            $this->dao = $this->dao->find($this->id);
        }else{
            //Erzeuge neue Session
            $this->dao->setAttribute(SessionDao::PROPERTY_ID, $this->id);
        }
    }

    public function set(string $key, $value) : void
    {
        $this->data_was_mutated = true;
        $this->storage[$key] = $value;
    }

    public function get($key)
    {
        if(!array_key_exists($key, $this->storage)){
            return null;
        }

        return $this->storage[$key];
    }

    public function save(): void
    {
        $this->dao->setAttribute('data', json_encode($this->storage));
        $this->dao->save();
    }


}
