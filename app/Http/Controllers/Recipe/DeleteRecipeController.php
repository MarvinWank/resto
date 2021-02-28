<?php


namespace App\Http\Controllers\Recipe;


use App\Exceptions\RecipeNotFoundException;
use App\Factories\RecipeFactory;
use App\Factories\UserFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteRecipeController extends Controller
{
    public function delete(Request $request, UserFactory $userFactory, RecipeFactory $recipeFactory)
    {
        $id = $request->json()->get('id');

        if ($id == null) {
            return response()->json([
                "status" => "error",
                "message" => "no id was given"
            ]);
        }

        try {
            $recipe = $recipeFactory->fromId($id);
        } catch (RecipeNotFoundException $e) {
            return response()->json([
                "status" => "error",
                "message" => "Recipe was not found"
            ]);
        }

        $currentUser = $userFactory->currentUser();

        //TODO: Author != Owner
        if ($currentUser->id() !== $recipe->author()->id()){
            return response()->json([
                "status" => "error",
                "message" => "Only the owner can delete a recipe"
            ]);
        }

        $recipeFactory->delete($recipe->id());
        return response()->json([
            "status" => "ok",
            "message" => "Recipe with ID $id was deleted"
        ]);
    }
}
