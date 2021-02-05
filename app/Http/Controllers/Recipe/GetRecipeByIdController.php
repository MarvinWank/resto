<?php


namespace App\Http\Controllers\Recipe;


use App\Factories\RecipeFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetRecipeByIdController extends Controller
{
    //TODO: Only give Recipes if user has access rights
    public function get(Request $request, RecipeFactory $recipeFactory): JsonResponse
    {
        $id = $request->json('id');
        if ($id == null) {
            return request()->json([
                "status" => "error",
                "message" => "no id was given"
            ]);
        }
        $recipe = $recipeFactory->fromId($id);

        return response()->json([
            "status" => "ok",
            "recipe" => $recipe->toArray()
        ]);
    }
}
