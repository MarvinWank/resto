<?php


namespace App\Http\Controllers\Recipe;


use App\Exceptions\RecipeNotFoundException;
use App\Factories\RecipeFactory;
use App\Http\Controllers\Controller;
use App\Value\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateRecipeController extends Controller
{
    private RecipeFactory $recipeFactory;


    public function __construct(\App\Factories\RecipeFactory $recipeFactory)
    {
        $this->recipeFactory = $recipeFactory;
    }

    public function handle(Request $request): JsonResponse
    {
        $data = $request->json()->all();
        $recipe = Recipe::fromArray($data['recipe']);

        try {
            $this->recipeFactory->update($recipe, $recipe->id());
        } catch (RecipeNotFoundException $exception) {
            $id = $recipe->id();
            return response()->json([
                "status" => "error",
                "message" => "No Recipe was found with ID $id"
            ], 403);
        }

        return response()->json([
            "status" => "ok",
            "recipe" => $recipe->toArray()
        ]);
    }
}
