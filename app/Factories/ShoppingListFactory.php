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

    private function addShoppingList(User $user, IngredientsSet $ingredients): ShoppingList
    {
        $shoppingList = new ShoppingList(null, $user->id(), $ingredients);
        $id = $this->shoppingListDao->add($shoppingList);
        return $shoppingList->with_id($id);
    }

    public function addItemsToShoppingList(User $user, IngredientsSet $ingredientsSet): ShoppingList
    {
        $existingList = $this->forUser($user);
        if ($existingList === null) {
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
        if ($existingIngredients->count() === 0) {
            return $newIngredients;
        }
        if ($newIngredients->count() === 0) {
            return $existingIngredients;
        }

        $resultIngredientSet = $existingIngredients;

        foreach ($newIngredients as $newIngredient) {

            $ingredientMerged = false;

            foreach ($existingIngredients as $existingIngredient) {
                /** @var Ingredient $newIngredient */
                /** @var Ingredient $existingIngredient */
                if ($existingIngredient->name() === $newIngredient->name()
                    && $existingIngredient->unit()->equals($newIngredient->unit())
                ) {

                    $resultIngredientSet = $resultIngredientSet->remove($existingIngredient);
                    $resultIngredientSet = $resultIngredientSet->add(
                        new Ingredient(
                            $existingIngredient->name(),
                            $existingIngredient->amount() + $newIngredient->amount(),
                            $existingIngredient->unit(),
                            $existingIngredient->kcal()
                        )
                    );
                    $ingredientMerged = true;
                    break;
                }
            }

            if (!$ingredientMerged) {
                $resultIngredientSet = $resultIngredientSet->add($newIngredient);
            }
        }

        return $resultIngredientSet;
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

    public function forUser(User $user): ?ShoppingList
    {
        $model = null;
        try {
            $model = $this->shoppingListDao->getByUserId($user->id());
        } catch (ModelNotFoundException $exception) {
            return null;
        }

        $ingredients = $model->ingredients();
        $ingredients = \Safe\json_decode($ingredients, true);
        $ingredients = IngredientsSet::fromArray($ingredients);

        return new ShoppingList(
            $model->id(),
            $model->userId(),
            $ingredients
        );
    }

    /** @throw ModelNotFoundException */
    public function deleteItems(ShoppingList $existingList, IngredientsSet $items): ShoppingList
    {
        foreach ($items as $item) {
            $existingList = $this->deleteItem($existingList, $item);
        }

        return $existingList;
    }

    /** @throw ModelNotFoundException */
    public function deleteItem(ShoppingList $existingList, Ingredient $item): ShoppingList
    {
        $ingredients = $existingList->ingredients()->remove($item);

        $newList = $this->shoppingListDao->updateIngredients($existingList->id(), $ingredients);

        //TODO: Write a proper fromDao() method
        return $this->fromId($newList->id());
    }

    public function deleteShoppingList(ShoppingList $list)
    {
        $this->shoppingListDao->deleteById($list->id());
    }
}
