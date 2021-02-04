<?php


namespace App\Http\Controllers\Recipe;


use App\Factories\RecipeFactory;
use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class GetRecipeByIdController extends Controller
{
    //TODO: Only give Recipes if user has access rights
    public function get(Request $request, RecipeFactory $recipeFactory): Request
    {
        $id = $request->json('id');
        if ($id == null) {
            return request()->json([
                "status" => "error",
                "message" => "no id was given"
            ]);
        }
        $recipe = $recipeFactory->fromId($id);

        return request()->json([
            "status" => "ok",
            "recipe" => $recipe->toArray()
        ]);
    }
}
