<?php


namespace App\Http\Controllers\Login;


use App\Factories\RecipeFactory;
use App\Factories\ShoppingListFactory;
use App\Factories\UserFactory;
use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginWithApiKeyController extends Controller
{
    private RecipeFactory $recipeFactory;
    private UserFactory $userFactory;
    private ShoppingListFactory $shoppingListFactory;
    private State $state;

    public function __construct(RecipeFactory $recipeFactory, UserFactory $userFactory, ShoppingListFactory $shoppingListFactory, State $state)
    {
        $this->recipeFactory = $recipeFactory;
        $this->userFactory = $userFactory;
        $this->shoppingListFactory = $shoppingListFactory;
        $this->state = $state;
    }

    public function handle(Request $request): JsonResponse
    {
        //ApiKey is validated by CheckApiKeyMiddleware
        $user = $this->userFactory->currentUser();
        $recipes = $this->recipeFactory->getTopRecipesForUser($user);
        $shoppingList = $this->shoppingListFactory->forUser($user);
        if ($shoppingList !== null) {
            $shoppingList = $shoppingList->toArray();
        }

        return response()->json([
            "status" => "ok",
            "apiKey" => $this->state->getStateId(),
            "user" => $user->toArray(),
            "topRecipes" => $recipes->toArray(),
            //Already made toArray
            "shoppingList" => $shoppingList
        ]);
    }
}
