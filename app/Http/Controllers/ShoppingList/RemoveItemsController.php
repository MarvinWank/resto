<?php


namespace App\Http\Controllers\ShoppingList;


use App\Factories\ShoppingListFactory;
use App\Factories\UserFactory;
use App\Http\Controllers\Controller;
use App\Value\IngredientsSet;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;

class RemoveItemsController extends Controller
{
    private UserFactory $userFactory;
    private ShoppingListFactory $shoppingListFactory;

    public function __construct(UserFactory $userFactory, ShoppingListFactory $shoppingListFactory)
    {

        $this->userFactory = $userFactory;
        $this->shoppingListFactory = $shoppingListFactory;
    }

    public function handle(Request $request): JsonResponse
    {
        $ingredients = $request->json('ingredients');
        $ingredients = IngredientsSet::fromArray($ingredients);

        $user = $this->userFactory->currentUser();
        $shoppingList = $this->shoppingListFactory->forUser($user);

        try {
            $shoppingList = $this->shoppingListFactory->deleteItems($shoppingList, $ingredients);
        } catch (ModelNotFoundException $exception) {
            $this->responseWithError("Fehler beim löschen der Zutaten");
        }

        return response()->json([
            "status" => "ok",
            "shoppingList" => $shoppingList->toArray()
        ]);
    }
}
