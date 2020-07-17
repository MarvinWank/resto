<?php

namespace App\Http\Controllers;

use App\Factories\UserFactory;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $userFactory;

    public function __construct(UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
    }

    public function login(Request $request)
    {
        $data = $request->json();
        $email = $data->get('email');
        $password = $data->get('password');

        $user = $this->userFactory->from_auth($email, $password);
        if($user === null){
            return response()->json(["status" => "fehler"]);
        }
        return response()->json(["status" => "ok", "user" => $user->toArray()]);

    }

}
