<?php

declare(strict_types=1);

namespace App\Value;

final class AddRecipeRequestDto
{
	private string $title;
	private DietStyle $dietStyle;
	private Cuisine $cuisine;
	private int $timeToPrepare;
	private array $ingredient;

	public function __construct (
		string $title,
		DietStyle $dietStyle,
		Cuisine $cuisine,
		int $timeToPrepare,
		array $ingredient
	)
	{
		$this->title = $title;
		$this->dietStyle = $dietStyle;
		$this->cuisine = $cuisine;
		$this->timeToPrepare = $timeToPrepare;
		$this->ingredient = $ingredient;
	}
	public function title(): string {
		return $this->title;
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

	public function ingredient(): array {
		return $this->ingredient;
	}


	public function with_title (string $title):self
	{
		return new self($title,$this->dietStyle,$this->cuisine,$this->timeToPrepare,$this->ingredient,);
	}

	public function with_dietStyle (DietStyle $dietStyle):self
	{
		return new self($this->title,$dietStyle,$this->cuisine,$this->timeToPrepare,$this->ingredient,);
	}

	public function with_cuisine (Cuisine $cuisine):self
	{
		return new self($this->title,$this->dietStyle,$cuisine,$this->timeToPrepare,$this->ingredient,);
	}

	public function with_timeToPrepare (int $timeToPrepare):self
	{
		return new self($this->title,$this->dietStyle,$this->cuisine,$timeToPrepare,$this->ingredient,);
	}

	public function with_ingredient (array $ingredient):self
	{
		return new self($this->title,$this->dietStyle,$this->cuisine,$this->timeToPrepare,$ingredient,);
	}
	public function toArray(): array
	{
		 return [
			 'title' => $this->title, 
			 'dietStyle' => $this->dietStyle, 
			 'cuisine' => $this->cuisine, 
			 'timeToPrepare' => $this->timeToPrepare, 
			 'ingredient' => $this->ingredient, 
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
		if(!array_key_exists('ingredient', $array)){
			 throw new \UnexpectedValueException('Array key ingredient does not exist');
		}

		return new self($array['title'],$array['dietStyle'],$array['cuisine'],$array['timeToPrepare'],$array['ingredient'],);
	}
}