<?php


namespace App\Http\Controllers\ShoppingList;


use App\Http\Controllers\Controller;
use App\Models\State;
use App\Value\IngredientsSet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddItemsController extends Controller
{
    public function addItems(Request $request, State $state): JsonResponse
    {
        $ingredients = \Safe\json_decode($request->post('ingredients'), true);
        $ingredients = IngredientsSet::fromArray($ingredients);

    }
}
