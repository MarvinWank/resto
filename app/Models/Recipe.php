<?php

namespace App\Models;

use App\Value\Cuisine;
use App\Value\DietStyle;
use Illuminate\Contracts\Support\Arrayable;

class Recipe
{
    private string $id;
    private User $author;
    private string $title;
    private DietStyle $diet_style;
    private Cuisine $cuisine;
    private int $time_to_prepare;
    private int $kcal;
    private array $ingredients;

    public function __construct
    (
        int $id,
        string $title,
        User $author,
        DietStyle $diet_style,
        Cuisine $cuisine,
        int $time_to_prepare,
        int $kcal,
        array $ingredients
    )
    {
        $this->title = $title;
        $this->diet_style = $diet_style;
        $this->cuisine = $cuisine;
        $this->time_to_prepare = $time_to_prepare;
        $this->kcal = $kcal;
        $this->ingredients = $ingredients;
        $this->author = $author;
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDietStyle(): DietStyle
    {
        return $this->diet_style;
    }

    public function getCuisine(): Cuisine
    {
        return $this->cuisine;
    }

    public function getTimeToPrepare(): int
    {
        return $this->time_to_prepare;
    }

    public function getKcal(): int
    {
        return $this->kcal;
    }

    public function getIngredients(): array
    {
        return $this->ingredients;
    }

}
