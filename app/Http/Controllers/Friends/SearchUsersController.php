<?php


namespace App\Http\Controllers\Friends;


use App\Factories\UserFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchUsersController extends Controller
{
    private UserFactory $userFactory;

    public function __construct(UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
    }

    public function handle(Request $request): JsonResponse
    {
        $searchWord = $request->post('searchQuery');
        $users = [];

        if (str_contains($searchWord, '@')) {
            $users = $this->userFactory->searchUsersByEmail($searchWord);
        } else {
            $users = $this->userFactory->searchUsersByName($searchWord);
        }

        return $this->respondWithSuccess(["users" => $users->toArray()]);
    }
}
