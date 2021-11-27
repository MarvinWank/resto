<?php
/** 
 * code generated by vog
 * https://github.com/MarvinWank/vog
 */
declare(strict_types=1);

namespace App\Value;


use InvalidArgumentException;

class TypeOfDish implements Enum
{
    public const VALUES = ['Vorspeise', 'Hauptspeise', 'Nachspeise', 'Snack', ];               
    public const NAMES = ['VORSPEISE', 'HAUPTSPEISE', 'NACHSPEISE', 'SNACK', ];               
    public const OPTIONS = [ 
        'VORSPEISE' => 'Vorspeise',
        'HAUPTSPEISE' => 'Hauptspeise',
        'NACHSPEISE' => 'Nachspeise',
        'SNACK' => 'Snack',
    ];

    public const VORSPEISE = 'Vorspeise';               
    public const HAUPTSPEISE = 'Hauptspeise';               
    public const NACHSPEISE = 'Nachspeise';               
    public const SNACK = 'Snack';                       
    private string $name;
    private string $value;
        
    private function __construct(string $name)
    {
        $this->name = $name;
        $this->value = self::OPTIONS[$name];
    }

    public static function VORSPEISE(): self
    {
        return new self('VORSPEISE');
    }
    
    public static function HAUPTSPEISE(): self
    {
        return new self('HAUPTSPEISE');
    }
    
    public static function NACHSPEISE(): self
    {
        return new self('NACHSPEISE');
    }
    
    public static function SNACK(): self
    {
        return new self('SNACK');
    }
    
    public static function fromValue(string $value): self
    {
        foreach (self::OPTIONS as $key => $option) {
            if ($value === $option) {
                return new self($key);
            }
        }

        throw new InvalidArgumentException("Unknown enum value '$value' given");
    }
    
    public static function fromName(string $name): self
    {
        if(!array_key_exists($name, self::OPTIONS)){
             throw new InvalidArgumentException("Unknown enum name $name given");
        }
        
        return new self($name);
    }
    
    public function equals(?self $other): bool
    {
        return (null !== $other) && ($this->name() === $other->name());
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function toString(): string
    {
        return $this->name;
    }
}