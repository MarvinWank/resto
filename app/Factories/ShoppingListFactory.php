<?php


namespace App\Factories;


use App\Daos\ShoppingListDao;
use App\Value\IngredientsSet;
use App\Value\ShoppingList;
use App\Value\User;

class ShoppingListFactory
{
    private ShoppingListDao $shoppingListDao;

    public function __construct(\App\Daos\ShoppingListDao $shoppingListDao)
    {
        $this->shoppingListDao = $shoppingListDao;
    }

    public function addShoppingList(User $user, IngredientsSet $ingredients): ShoppingList
    {
        $shoppingList = new ShoppingList(null, $user->id(), $ingredients);
        $id = $this->shoppingListDao->add($shoppingList);
        return $shoppingList->with_id($id);
    }

    public function fromId(int $id): ShoppingList
    {
        $model = $this->shoppingListDao->getById($id);

        $ingredients = $model->ingredients();
        $ingredients = \Safe\json_decode($ingredients, true);
        $ingredients = IngredientsSet::fromArray($ingredients);

        return new ShoppingList(
            $model->id(),
            $model->userId(),
            $ingredients
        );
    }

    public function deleteShoppingList(ShoppingList $list)
    {
        $this->shoppingListDao->deleteById($list->id());
    }
}
