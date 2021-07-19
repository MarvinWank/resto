<?php


namespace App\Http\Controllers\Recipe;


use App\Factories\RecipeFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetRecipeByIdController extends Controller
{
    private RecipeFactory  $recipeFactory;

    public function __construct(RecipeFactory $recipeFactory)
    {
        $this->recipeFactory = $recipeFactory;
    }

    //TODO: Only give Recipes if user has access rights
    public function handle(Request $request): JsonResponse
    {
        $id = $request->json('id');
        if ($id == null) {
            return response()->json([
                "status" => "error",
                "message" => "no id was given"
            ]);
        }
        $recipe = $this->recipeFactory->fromId($id);

        return response()->json([
            "status" => "ok",
            "recipe" => $recipe->toArray()
        ]);
    }
}
