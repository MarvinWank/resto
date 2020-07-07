<?php


namespace App\Models;


class User
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

}
