<?php


namespace App\Models;


use Illuminate\Contracts\Support\Arrayable;

class User implements Arrayable
{
    /** @var int $id */
    private $id;
    /** @var string $name */
    private $name;
    /** @var string $email */
    private $email;

    public function __construct(int $id, string $name, string $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function getID(): int
    {
        return $this->id;
    }

    public function get_name(): string
    {
        return $this->name;
    }

    public function get_email(): string
    {
        return $this->email;
    }

    public function toArray()
    {
        return [
            "name" => $this->name,
            "email" => $this->email,
        ];
    }
}
