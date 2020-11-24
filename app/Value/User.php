<?php

declare(strict_types=1);

namespace App\Value;

final class User
{
	private int $id;
	private string $name;
	private string $email;

	public function __construct (
		int $id,
		string $name,
		string $email
	)
	{
		$this->id = $id;
		$this->name = $name;
		$this->email = $email;
	}
	public function id(): int {
		return $this->id;
	}

	public function name(): string {
		return $this->name;
	}

	public function email(): string {
		return $this->email;
	}


	public function with_id (int $id):self
	{
		return new self($id,$this->name,$this->email,);
	}

	public function with_name (string $name):self
	{
		return new self($this->id,$name,$this->email,);
	}

	public function with_email (string $email):self
	{
		return new self($this->id,$this->name,$email,);
	}
	public function toArray(): array
	{
		 return [
			 'id' => $this->id, 
			 'name' => $this->name, 
			 'email' => $this->email, 
		];
	}

	public static function fromArray(array $array): self
	{
		if(!array_key_exists('id', $array)){
			 throw new \UnexpectedValueException('Array key id does not exist');
		}
		if(!array_key_exists('name', $array)){
			 throw new \UnexpectedValueException('Array key name does not exist');
		}
		if(!array_key_exists('email', $array)){
			 throw new \UnexpectedValueException('Array key email does not exist');
		}

		return new self($array['id'],$array['name'],$array['email'],);
	}

	public function __toString(): string
	{
		return strval($this->id);
	}

	public function toString(): string
	{
		return strval($this->id);
	}
}