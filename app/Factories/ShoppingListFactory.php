<?php


namespace App\Factories;


use App\Daos\ShoppingListDao;
use App\Value\Ingredient;
use App\Value\IngredientsSet;
use App\Value\ShoppingList;
use App\Value\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function addItemsToShoppingList(User $user, IngredientsSet $ingredientsSet): ShoppingList
    {
        $listExists = true;
        $existingList = null;

        try {
            $existingList = $this->forUser($user);
        } catch (ModelNotFoundException $exception) {
            $listExists = false;
        }

        if (!$listExists) {
            //Create new Shopping List
            return $this->addShoppingList($user, $ingredientsSet);
        } else {
            $existingIngredients = $existingList->ingredients();
            $resultIngredients = $this->mergeIngredients($existingIngredients, $ingredientsSet);
            $this->shoppingListDao->updateIngredients($existingList->id(), $resultIngredients);

            return $this->fromId($existingList->id());
        }
    }

    private function mergeIngredients(IngredientsSet $existingIngredients, IngredientsSet $newIngredients): IngredientsSet
    {
        $resultIngredientSet = IngredientsSet::fromArray([]);
        $resultIngredient = null;

        foreach ($existingIngredients as $existingIngredient) {
            /** @var Ingredient $existingIngredient */
            $resultIngredient = $existingIngredient;

            foreach ($newIngredients as $newIngredient) {
                /** @var Ingredient $newIngredient */
                if ($existingIngredient->name() === $newIngredient->name()) {
                    $resultIngredient = new Ingredient(
                        $existingIngredient->name(),
                        $existingIngredient->amount() + $newIngredient->amount(),
                        $existingIngredient->unit(),
                        $existingIngredient->kcal()
                    );
                    break;
                }
            }

            $resultIngredientSet = $resultIngredientSet->add($resultIngredient);
        }

        return $resultIngredientSet;
    }

    public
    function fromId(int $id): ShoppingList
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

    public
    function forUser(User $user): ShoppingList
    {
        $model = $this->shoppingListDao->getByUserId($user->id());

        $ingredients = $model->ingredients();
        $ingredients = \Safe\json_decode($ingredients, true);
        $ingredients = IngredientsSet::fromArray($ingredients);

        return new ShoppingList(
            $model->id(),
            $model->userId(),
            $ingredients
        );
    }

    public
    function deleteShoppingList(ShoppingList $list)
    {
        $this->shoppingListDao->deleteById($list->id());
    }
}
