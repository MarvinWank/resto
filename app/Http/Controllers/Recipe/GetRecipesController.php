<?php


namespace App\Http\Controllers\Recipe;


use App\Factories\RecipeFactory;
use App\Factories\UserFactory;
use Illuminate\Http\JsonResponse;

class GetRecipesController
{
    public function getAll(RecipeFactory $recipeFactory, UserFactory $userFactory): JsonResponse
    {
        $currentUser = $userFactory->currentUser();
        $recipes = $recipeFactory->getAllRecipesForUser($currentUser);

        return response()->json([
            "status" => "ok",
            "recipes" => $recipes->toArray()
        ]);
    }

    public function getTop(RecipeFactory $recipeFactory, UserFactory $userFactory): JsonResponse
    {
        $currentUser = $userFactory->currentUser();
        $recipes = $recipeFactory->getTopRecipesForUser($currentUser, 3);

        return response()->json([
            "status" => "ok",
            "recipes" => $recipes->toArray()
        ]);
    }
}
