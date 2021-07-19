<?php


namespace App\Http\Controllers\Recipe;


use App\Factories\RecipeFactory;
use App\Factories\UserFactory;
use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchRecipesController extends Controller
{
    private UserFactory $userFactory;
    private RecipeFactory $recipeFactory;

    public function __construct(UserFactory $userFactory, RecipeFactory $recipeFactory)
    {
        $this->userFactory = $userFactory;
        $this->recipeFactory = $recipeFactory;
    }

    public function handle(
        Request $request
    ): JsonResponse
    {
        $search = $request->json()->get('search');
        if ($search === null) {
            return $this->responseWithError("No Search Term was provided");
        }

        $user = $this->userFactory->currentUser();

        $recipes = $this->recipeFactory->getRecipesForSaytSearch($search, $user, 15);

        return response()->json([
            "status" => "ok",
            "recipes" => $recipes->toArray()
        ]);
    }
}
