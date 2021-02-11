<?php


namespace App\Exceptions;


use Exception;

class RecipeNotFoundException extends Exception
{
    public static function recipeNotFound(int $recipeId)
    {
        return new self("No Recipe was found with ID $recipeId");
    }
}
