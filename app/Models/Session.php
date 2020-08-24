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
    /** @var bool $data_was_mutated */
    private $data_was_mutated;

    public function __construct(string $id, array $storage = [])
    {
        $this->id = $id;
        $this->storage = $storage;
        $this->data_was_mutated = false;
    }


    public function set(string $key, $value): void
    {
        $this->data_was_mutated = true;
        $value = serialize($value);

        $this->storage[$key] = $value;
    }

    public function get($key)
    {
        if (!array_key_exists($key, $this->storage)) {
            return null;
        }

        return unserialize($this->storage[$key]);
    }

    public function dataWasMutated(): bool
    {
        return $this->data_was_mutated;
    }

    public function getAll(): array
    {
        return $this->storage;
    }

}
