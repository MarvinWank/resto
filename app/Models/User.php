<?php


namespace App\Models;


use Illuminate\Contracts\Support\Arrayable;

class User implements Arrayable
{
    private $name;
    private $email;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
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
