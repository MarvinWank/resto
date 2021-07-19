<?php


namespace App\Http\Controllers\Friends;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchUsersController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $searchWord = $request->post('searchQuery');

        if (str_contains($searchWord, '@')){

        }else{

        }
    }
}
