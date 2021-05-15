<?php

namespace App\Http\Controllers;

use App\Factories\RecipeFactory;
use App\Factories\ShoppingListFactory;
use App\Factories\UserFactory;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    private UserFactory $userFactory;

    public function __construct(UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
    }

    public function login(Request $request, State $session, RecipeFactory $recipeFactory, ShoppingListFactory $shoppingListFactory): JsonResponse
    {
        $data = $request->json();
        $email = $data->get('email');
        $password = $data->get('password');

        $user = $this->userFactory->fromAuth($email, $password);

        if ($user === null) {
            return response()->json(["status" => "fehler"]);
        }

        $recipes = $recipeFactory->getTopRecipesForUser($user, 5);
        $shoppingList = $shoppingListFactory->forUser($user);

        $session->setUserID($user->id());
        return response()->json([
            "status" => "ok",
            "apiKey" => $session->getStateId(),
            "user" => $user->toArray(),
            "topRecipes" => $recipes->toArray(),
            "shoppingList" => $shoppingList->toArray()
        ]);
    }

    public function login_with_api_key(State $state, RecipeFactory  $recipeFactory, UserFactory $userFactory, ShoppingListFactory $shoppingListFactory)
    {
        //ApiKey is validated by CheckApiKeyMiddleware

        $userID = $state->getUserID();
        $user = $userFactory->fromId($userID);
        $recipes = $recipeFactory->getTopRecipesForUser($user);
        $shoppingList = $shoppingListFactory->forUser($user);

        return response()->json([
            "status" => "ok",
            "apiKey" => $state->getStateId(),
            "user" => $user->toArray(),
            "topRecipes" => $recipes->toArray(),
            "shoppingList" => $shoppingList->toArray()
        ]);
    }

}
