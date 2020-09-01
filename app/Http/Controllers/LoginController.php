<?php

namespace App\Http\Controllers;

use App\Factories\UserFactory;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function login(Request $request, State $session)
    {
        $data = $request->json();
        $email = $data->get('email');
        $password = $data->get('password');

        $user = $this->userFactory->from_auth($email, $password);

        if ($user === null) {
            return response()->json(["status" => "fehler"]);
        }

        $session->setUserID($user->getID());
        return response()->json(["status" => "ok", "user" => $user->toArray()]);
    }

}
