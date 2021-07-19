<?php


namespace App\Http\Controllers\Recipe;


use App\Factories\RecipeFactory;
use App\Factories\UserFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetTopRecipesController extends Controller
{
    private RecipeFactory $recipeFactory;
    private UserFactory $userFactory;

    public function __construct(RecipeFactory $recipeFactory, UserFactory $userFactory)
    {
        $this->recipeFactory = $recipeFactory;
        $this->userFactory = $userFactory;
    }


    public function handle(Request $request): JsonResponse
    {
        $currentUser = $this->userFactory->currentUser();
        $recipes = $this->recipeFactory->getTopRecipesForUser($currentUser, 3);

        return response()->json([
            "status" => "ok",
            "recipes" => $recipes->toArray()
        ]);
    }

}
