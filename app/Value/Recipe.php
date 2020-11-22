<?php

declare(strict_types=1);

namespace App\Value;

final class Recipe
{
	private int $id;
	private string $title;
	private User $author;
	private DietStyle $dietStyle;
	private Cuisine $cuisine;
	private int $timeToPrepare;
	private array $ingredients;

	public function __construct (
		int $id,
		string $title,
		User $author,
		DietStyle $dietStyle,
		Cuisine $cuisine,
		int $timeToPrepare,
		array $ingredients
	)
	{
		$this->id = $id;
		$this->title = $title;
		$this->author = $author;
		$this->dietStyle = $dietStyle;
		$this->cuisine = $cuisine;
		$this->timeToPrepare = $timeToPrepare;
		$this->ingredients = $ingredients;
	}
	public function id(): int {
		return $this->id;
	}

	public function title(): string {
		return $this->title;
	}

	public function author(): User {
		return $this->author;
	}

	public function dietStyle(): DietStyle {
		return $this->dietStyle;
	}

	public function cuisine(): Cuisine {
		return $this->cuisine;
	}

	public function timeToPrepare(): int {
		return $this->timeToPrepare;
	}

	public function ingredients(): array {
		return $this->ingredients;
	}


	public function with_id (int $id):self
	{
		return new self($id,$this->title,$this->author,$this->dietStyle,$this->cuisine,$this->timeToPrepare,$this->ingredients,);
	}

	public function with_title (string $title):self
	{
		return new self($this->id,$title,$this->author,$this->dietStyle,$this->cuisine,$this->timeToPrepare,$this->ingredients,);
	}

	public function with_author (User $author):self
	{
		return new self($this->id,$this->title,$author,$this->dietStyle,$this->cuisine,$this->timeToPrepare,$this->ingredients,);
	}

	public function with_dietStyle (DietStyle $dietStyle):self
	{
		return new self($this->id,$this->title,$this->author,$dietStyle,$this->cuisine,$this->timeToPrepare,$this->ingredients,);
	}

	public function with_cuisine (Cuisine $cuisine):self
	{
		return new self($this->id,$this->title,$this->author,$this->dietStyle,$cuisine,$this->timeToPrepare,$this->ingredients,);
	}

	public function with_timeToPrepare (int $timeToPrepare):self
	{
		return new self($this->id,$this->title,$this->author,$this->dietStyle,$this->cuisine,$timeToPrepare,$this->ingredients,);
	}

	public function with_ingredients (array $ingredients):self
	{
		return new self($this->id,$this->title,$this->author,$this->dietStyle,$this->cuisine,$this->timeToPrepare,$ingredients,);
	}
	public function toArray(): array
	{
		 return [
			 'id' => $this->id, 
			 'title' => $this->title, 
			 'author' => strval($this->author), 
			 'dietStyle' => strval($this->dietStyle), 
			 'cuisine' => strval($this->cuisine), 
			 'timeToPrepare' => $this->timeToPrepare, 
			 'ingredients' => $this->ingredients, 
		];
	}

	public static function fromArray(array $array): self
	{
		if(!array_key_exists('id', $array)){
			 throw new \UnexpectedValueException('Array key id does not exist');
		}
		if(!array_key_exists('title', $array)){
			 throw new \UnexpectedValueException('Array key title does not exist');
		}
		if(!array_key_exists('author', $array)){
			 throw new \UnexpectedValueException('Array key author does not exist');
		}
		if(!array_key_exists('dietStyle', $array)){
			 throw new \UnexpectedValueException('Array key dietStyle does not exist');
		}
		if(!array_key_exists('cuisine', $array)){
			 throw new \UnexpectedValueException('Array key cuisine does not exist');
		}
		if(!array_key_exists('timeToPrepare', $array)){
			 throw new \UnexpectedValueException('Array key timeToPrepare does not exist');
		}
		if(!array_key_exists('ingredients', $array)){
			 throw new \UnexpectedValueException('Array key ingredients does not exist');
		}

		return new self($array['id'],$array['title'],$array['author'],$array['dietStyle'],$array['cuisine'],$array['timeToPrepare'],$array['ingredients'],);
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