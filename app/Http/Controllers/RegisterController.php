<?php


namespace App\Http\Controllers;


use App\Factories\UserFactory;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    private State  $state;
    private UserFactory  $userFactory;

    public function __construct(State $state, UserFactory  $userFactory)
    {
        $this->state = $state;
        $this->userFactory = $userFactory;
    }

    public function handle(Request $request): JsonResponse
    {
        $data = $request->json();
        $userName = $data->get('name');
        $email = $data->get('email');
        $password = $data->get('password');

        $user = null;
        try {
            $user = $this->userFactory->addUser($userName, $email, $password);
        }catch (\Throwable $exception){
            $this->responseWithError($exception->getMessage());
        }
        $this->state->setUserID($user->id());

        return  response()->json([
            "status" => "ok",
            "apiKey" => $this->state->getStateId(),
            "user" => $user->toArray(),
            "topRecipes" => []
        ]);
    }
}
