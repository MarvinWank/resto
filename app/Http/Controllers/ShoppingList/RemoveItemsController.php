<?php


namespace App\Http\Controllers\ShoppingList;


use App\Factories\ShoppingListFactory;
use App\Factories\UserFactory;
use App\Http\Controllers\Controller;
use App\Value\IngredientsSet;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;

class RemoveItemsController extends Controller
{
    public function removeIngredients(
        Request $request,
        UserFactory $userFactory,
        ShoppingListFactory $shoppingListFactory,
        Logger $logger
    )
    {
        $ingredients = $request->json('ingredients');
        $ingredients = IngredientsSet::fromArray($ingredients);

        $user = $userFactory->currentUser();
        $shoppingList = $shoppingListFactory->forUser($user);

        try {
            $shoppingList = $shoppingListFactory->deleteItems($shoppingList, $ingredients);
        } catch (ModelNotFoundException $exception) {
            $logger->error($exception->getMessage());
            $this->responseWithError("Fehler beim löschen der Zutaten");
        }

        return response()->json([
            "status" => "ok",
            "shoppingList" => $shoppingList->toArray()
        ]);
    }
}
