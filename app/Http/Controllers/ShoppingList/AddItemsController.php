<?php


namespace App\Http\Controllers\ShoppingList;


use App\Factories\ShoppingListFactory;
use App\Factories\UserFactory;
use App\Http\Controllers\Controller;
use App\Value\IngredientsSet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddItemsController extends Controller
{
    public function addItems(Request $request, UserFactory $userFactory, ShoppingListFactory $shoppingListFactory): JsonResponse
    {
        $ingredients = \Safe\json_decode($request->post('ingredients'), true);
        $ingredients = IngredientsSet::fromArray($ingredients);
        $user = $userFactory->currentUser();

        $newList = $shoppingListFactory->addItemsToShoppingList($user, $ingredients);

        return response()->json([
            "status" => "ok",
            "shoppingList" => $newList->toArray()
        ]);
    }
}
