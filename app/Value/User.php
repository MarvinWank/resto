<?php
/** 
 * code generated by vog
 * https://github.com/MarvinWank/vog
 */
declare(strict_types=1);

namespace App\Value;


use UnexpectedValueException;

final class User implements ValueObject
{
    private int $id;
    private string $name;
    private string $email;

    public function __construct (
        int $id,
        string $name,
        string $email
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }
    
    public function getId(): int 
    {
        return $this->id;
    }
    
    public function getName(): string 
    {
        return $this->name;
    }
    
    public function getEmail(): string 
    {
        return $this->email;
    }
    
    public function withId(int $id): self 
    {
        return new self(
            $id,
            $this->name,
            $this->email
        );
    }
    
    public function withName(string $name): self 
    {
        return new self(
            $this->id,
            $name,
            $this->email
        );
    }
    
    public function withEmail(string $email): self 
    {
        return new self(
            $this->id,
            $this->name,
            $email
        );
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
        if (!array_key_exists('id', $array)) {
            throw new UnexpectedValueException('Array key id does not exist');
        }
        
        if (!array_key_exists('name', $array)) {
            throw new UnexpectedValueException('Array key name does not exist');
        }
        
        if (!array_key_exists('email', $array)) {
            throw new UnexpectedValueException('Array key email does not exist');
        }
        
        return new self(
            $array['id'],
            $array['name'],
            $array['email']
        );
    }
        
    private function valueToArray($value)
    {
        if (method_exists($value, 'toArray')) {
            return $value->toArray();
        }
        
        return (string) $value;
    }    
    public function equals($value): bool
    {
        $ref = $this->toArray();
        $val = $value->toArray();
        
        return ($ref === $val);
    }
    public function __toString(): string
    {
        return $this->toString();
    }
    
    public function toString(): string
    {
        return (string) $this->id;
    }
    
}