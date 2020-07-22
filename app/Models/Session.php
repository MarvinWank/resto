<?php


namespace App\Models;

use App\Daos\SessionDao;
use Faker\Provider\Uuid;
use Illuminate\Contracts\Support\Arrayable;
use function json_decode;

class Session
{
    /** @var string $id */
    private $id;
    /** @var array $storage */
    private $storage;
    /** @var array $dao_storage */
    private $dao_storage;
    /** @var SessionDao $dao */
    private $dao;
    /** @var bool $data_was_mutated */
    private $data_was_mutated = false;

    public function __construct(SessionDao $dao)
    {
        $this->dao = $dao;
    }

    public function init(?string $id)
    {
        if($id === null){
            $this->id = Uuid::uuid();
        }else{
            $this->id = $id;
        }

        //Session ist schon vorhanden
        if ($this->dao->find($this->id) !== null) {
            $this->dao = $this->dao->find($this->id);
        } else {
            //Erzeuge neue Session
            $this->dao->setAttribute(SessionDao::PROPERTY_ID, $this->id);
        }
        $this->storage = json_decode($this->dao->getAttribute(SessionDao::PROPERTY_DATA));
        $this->dao_storage = json_decode($this->dao->getAttribute(SessionDao::PROPERTY_DATA));
    }

    public function setObject(string $key, Arrayable $value): void
    {
        $this->data_was_mutated = true;
        $this->storage[$key] = $value;
        $this->dao_storage[$key] = $value->toArray();
    }

    public function setPrimitive(string $key, $value): void
    {
        $this->data_was_mutated = true;
        $this->storage[$key] = $value;
        $this->dao_storage[$key] = $value;
    }

    public function get($key)
    {
        if (!array_key_exists($key, $this->storage)) {
            return null;
        }

        return $this->storage[$key];
    }

    public function save(): void
    {
        if ($this->data_was_mutated) {
            $this->dao->setAttribute(SessionDao::PROPERTY_DATA, json_encode($this->dao_storage));
            $this->dao->save();
        }
    }


}
