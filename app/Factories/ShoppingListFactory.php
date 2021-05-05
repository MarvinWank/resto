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
}
