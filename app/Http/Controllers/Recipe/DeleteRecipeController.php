<?php


namespace App\Http\Controllers\Recipe;


use App\Exceptions\RecipeNotFoundException;
use App\Factories\RecipeFactory;
use App\Factories\UserFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteRecipeController extends Controller
{
    private UserFactory  $userFactory;
    private RecipeFactory  $recipeFactory;

    public function __construct(UserFactory $userFactory, RecipeFactory $recipeFactory)
    {
        $this->userFactory = $userFactory;
        $this->recipeFactory = $recipeFactory;
    }

    public function handle(Request $request): JsonResponse
    {
        $id = $request->json()->get('id');

        if ($id == null) {
            return response()->json([
                "status" => "error",
                "message" => "no id was given"
            ]);
        }

        try {
            $recipe = $this->recipeFactory->fromId($id);
        } catch (RecipeNotFoundException $e) {
            return response()->json([
                "status" => "error",
                "message" => "Recipe was not found"
            ]);
        }

        $currentUser = $this->userFactory->currentUser();

        //TODO: Author != Owner
        if ($currentUser->id() !== $recipe->author()->id()){
            return response()->json([
                "status" => "error",
                "message" => "Only the owner can delete a recipe"
            ]);
        }

        $this->recipeFactory->delete($recipe->id());
        return response()->json([
            "status" => "ok",
            "message" => "Recipe with ID $id was deleted"
        ]);
    }
}
