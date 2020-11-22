<?php

declare(strict_types=1);

namespace App\Value;

final class AddRecipeRequestDto
{
	private string $title;
	private string $dietStyle;
	private string $cuisine;
	private int $timeToPrepare;
	private array $ingredients;

	public function __construct (
		string $title,
		string $dietStyle,
		string $cuisine,
		int $timeToPrepare,
		array $ingredients
	)
	{
		$this->title = $title;
		$this->dietStyle = $dietStyle;
		$this->cuisine = $cuisine;
		$this->timeToPrepare = $timeToPrepare;
		$this->ingredients = $ingredients;
	}
	public function title(): string {
		return $this->title;
	}

	public function dietStyle(): string {
		return $this->dietStyle;
	}

	public function cuisine(): string {
		return $this->cuisine;
	}

	public function timeToPrepare(): int {
		return $this->timeToPrepare;
	}

	public function ingredients(): array {
		return $this->ingredients;
	}


	public function with_title (string $title):self
	{
		return new self($title,$this->dietStyle,$this->cuisine,$this->timeToPrepare,$this->ingredients,);
	}

	public function with_dietStyle (string $dietStyle):self
	{
		return new self($this->title,$dietStyle,$this->cuisine,$this->timeToPrepare,$this->ingredients,);
	}

	public function with_cuisine (string $cuisine):self
	{
		return new self($this->title,$this->dietStyle,$cuisine,$this->timeToPrepare,$this->ingredients,);
	}

	public function with_timeToPrepare (int $timeToPrepare):self
	{
		return new self($this->title,$this->dietStyle,$this->cuisine,$timeToPrepare,$this->ingredients,);
	}

	public function with_ingredients (array $ingredients):self
	{
		return new self($this->title,$this->dietStyle,$this->cuisine,$this->timeToPrepare,$ingredients,);
	}
	public function toArray(): array
	{
		 return [
			 'title' => $this->title, 
			 'dietStyle' => $this->dietStyle, 
			 'cuisine' => $this->cuisine, 
			 'timeToPrepare' => $this->timeToPrepare, 
			 'ingredients' => $this->ingredients, 
		];
	}

	public static function fromArray(array $array): self
	{
		if(!array_key_exists('title', $array)){
			 throw new \UnexpectedValueException('Array key title does not exist');
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

		return new self($array['title'],$array['dietStyle'],$array['cuisine'],$array['timeToPrepare'],$array['ingredients'],);
	}
}