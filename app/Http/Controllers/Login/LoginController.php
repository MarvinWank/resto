<?php

namespace App\Http\Controllers\Login;

use App\Factories\RecipeFactory;
use App\Factories\ShoppingListFactory;
use App\Factories\UserFactory;
use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    private UserFactory $userFactory;
    private State $session;
    private RecipeFactory $recipeFactory;
    private ShoppingListFactory $shoppingListFactory;

    public function __construct(UserFactory $userFactory, State $session, RecipeFactory $recipeFactory, ShoppingListFactory $shoppingListFactory)
    {
        $this->userFactory = $userFactory;
        $this->session = $session;
        $this->recipeFactory = $recipeFactory;
        $this->shoppingListFactory = $shoppingListFactory;
    }

    public function handle(Request $request): JsonResponse
    {
        $data = $request->json();
        $email = $data->get('email');
        $password = $data->get('password');

        $user = $this->userFactory->fromAuth($email, $password);

        if ($user === null) {
            return $this->responseWithError("Login unsuccessful");
        }

        $recipes = $this->recipeFactory->getTopRecipesForUser($user, 5);
        $shoppingList = $this->shoppingListFactory->forUser($user);
        if ($shoppingList !== null) {
            $shoppingList = $shoppingList->toArray();
        }

        $this->session->setUserID($user->id());
        return response()->json([
            "status" => "ok",
            "apiKey" => $this->session->getStateId(),
            "user" => $user->toArray(),
            "topRecipes" => $recipes->toArray(),
            "shoppingList" => $shoppingList
        ]);
    }

}
