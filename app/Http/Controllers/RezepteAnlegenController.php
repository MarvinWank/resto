<?php


namespace App\Http\Controllers;


use App\Value\AddRecipeRequestDto;
use Illuminate\Http\Request;

class RezepteAnlegenController extends Controller
{
    public function add(Request $request)
    {
        $data = $request->json()->all();
        $data = AddRecipeRequestDto::fromArray($data);

        $foo = "bar";
    }
}
