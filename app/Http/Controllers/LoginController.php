<?php

namespace App\Http\Controllers;

use App\Factories\RecipeFactory;
use App\Factories\UserFactory;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private UserFactory $userFactory;

    public function __construct(UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
    }

    public function login(Request $request, State $session, RecipeFactory $recipeFactory)
    {
        $data = $request->json();
        $email = $data->get('email');
        $password = $data->get('password');

        $user = $this->userFactory->from_auth($email, $password);

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

}
