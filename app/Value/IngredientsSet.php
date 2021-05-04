<?php
/** 
 * code generated by vog
 * https://github.com/MarvinWank/vog
 */
declare(strict_types=1);

namespace App\Value;


use UnexpectedValueException;
use BadMethodCallException;

class IngredientsSet implements Set,\Countable,\ArrayAccess,\Iterator
{        
    private array $items;
    private int $position;
        
    private function __construct(array $items = [])
    {
        $this->position = 0;
        $this->items = $items;
    }    public static function fromArray(array $items) {
        foreach ($items as $key => $item) {
            $type = gettype($item);
            switch ($type) {
                case 'object':
                    if (!$item instanceof Ingredient){
                        throw new UnexpectedValueException('array expects items of Ingredient but has ' . $type . ' on index ' . $key); 
                    }    
                    break;
                case 'array':
                    if(is_a(Ingredient::class, ValueObject::class, true) || is_a(Ingredient::class, Set::class, true)) {
                        $items[$key] = Ingredient::fromArray($item);
                    } else {
                        throw new UnexpectedValueException('fromArray can not create Ingredient from array on index ' . $key);
                    }
                    break;    
                case 'string':
                    if(is_a(Ingredient::class, Enum::class, true)) {
                        $items[$key] = Ingredient::fromName($item);
                    } else {
                        throw new UnexpectedValueException('fromArray can not create Ingredient from string on index ' . $key);
                    }
                    break;    
                default:
                    if ($type !== 'Ingredient') {
                        throw new UnexpectedValueException('fromArray expects items of Ingredient but has ' . $type . ' on index ' . $key);
                    }
                    break;
            }
            
        }
        return new self($items);
    }
    public function toArray() {
        $return = [];
        foreach ($this->items as $item) {
            if(is_a(Ingredient::class, ValueObject::class, true) || is_a(Ingredient::class, Set::class, true)) {
                $return[] = $item->toArray();
            }
            
            if(is_a(Ingredient::class, Enum::class, true)) {
                $return[] = $item->toString();
            }
        }
        
        return $return;
    }
    public function equals(?self $other): bool
    {
        $ref = $this->toArray();
        $val = $other->toArray();
                
        return ($ref === $val);
    }    
    
    public function contains(Ingredient $item): bool {
        return array_search($item, $this->items) !== false;
    }
    
    public function count(): int
    {
        return count($this->items);
    }
    
        public function offsetExists($offset) {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset) {
        return $this->items[$offset];
    }

    public function current() {
        return $this->items[$this->position];
    }

    public function rewind() {
        $this->position = 0;
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
    }

    public function valid() {
        return isset($this->items[$this->position]);
    }
    
    public function add(Ingredient $item): self {
        $values = $this->toArray();
        $values[] = $item;
        return self::fromArray($values);
    }

    public function offsetSet($offset, $value) {
        throw new BadMethodCallException('ArrayAccess offsetSet is forbidden, use ->add()');
    }

    public function offsetUnset($offset) {
        throw new BadMethodCallException('ArrayAccess offsetUnset is forbidden, use ->remove()');
    }
    
    public function remove(Ingredient $item): self {
        $values = $this->toArray();
        if(($key = array_search($item->toArray(), $values)) !== false) {
            unset($values[$key]);
        }
        $values = array_values($values);
        
        return self::fromArray($values);
    }
}