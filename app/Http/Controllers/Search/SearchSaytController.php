<?php


namespace App\Http\Controllers\Search;


use App\Factories\RecipeFactory;
use App\Factories\UserFactory;
use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchSaytController extends Controller
{
    public function saytList(
        Request $request,
        State $state,
        UserFactory $userFactory,
        RecipeFactory $recipeFactory
    ): JsonResponse
    {
        $search = $request->json()->get('search');
        if($search === null){
            return $this->responseWithError("No Search Term was provided");
        }

        $userID = $state->getUserID();
        $user = $userFactory->fromId($userID);

        $recipes = $recipeFactory->getRecipesForSaytSearch($search, $user, 15);

        return response()->json([
            "status" => "ok",
            "recipes" => $recipes->toArray()
        ]);
    }
}
