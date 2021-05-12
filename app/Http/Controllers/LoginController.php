<?php

namespace App\Http\Controllers;

use App\Factories\RecipeFactory;
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

    public function login(Request $request, State $session, RecipeFactory $recipeFactory): JsonResponse
    {
        $data = $request->json();
        $email = $data->get('email');
        $password = $data->get('password');

        $user = $this->userFactory->fromAuth($email, $password);

        if ($user === null) {
            return response()->json(["status" => "fehler"]);
        }

        $recipes = $recipeFactory->getTopRecipesForUser($user, 5);

        $session->setUserID($user->id());
        return response()->json([
            "status" => "ok",
            "user" => $user->toArray(),
            "topRecipes" => $recipes->toArray(),
            "apiKey" => $session->getStateId()
        ]);
    }

    public function login_with_api_key(State $state, RecipeFactory  $recipeFactory, UserFactory $userFactory)
    {
        //ApiKey is validated by CheckApiKeyMiddleware

        $userID = $state->getUserID();
        $user = $userFactory->fromId($userID);
        $recipes = $recipeFactory->getTopRecipesForUser($user);

        return response()->json([
            "status" => "ok",
            "user" => $user->toArray(),
            "topRecipes" => $recipes->toArray(),
            "apiKey" => $state->getStateId()
        ]);
    }

}
