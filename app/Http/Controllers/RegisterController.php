<?php


namespace App\Http\Controllers;


use App\Factories\UserFactory;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(
        Request $request,
        State $state,
        UserFactory $userFactory
    ): JsonResponse
    {
        $data = $request->json();
        $userName = $data->get('name');
        $email = $data->get('email');
        $password = $data->get('password');

        $user = null;
        try {
            $user = $userFactory->addUser($userName, $email, $password);
        }catch (\Throwable $exception){
            $this->responseWithError($exception->getMessage());
        }
        $state->setUserID($user->id());

        return  response()->json([
            "status" => "ok",
            "apiKey" => $state->getStateId(),
            "user" => $user->toArray(),
            "topRecipes" => []
        ]);
    }
}
