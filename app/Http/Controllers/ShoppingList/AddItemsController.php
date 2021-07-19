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

        $newList = $this->shoppingListFactory->addItemsToShoppingList($user, $ingredients);

        return response()->json([
            "status" => "ok",
            "shoppingList" => $newList->toArray()
        ]);
    }
}
