<?php


namespace factories;


use App\Factories\ShoppingListFactory;
use App\Value\Ingredient;
use App\Value\IngredientsSet;
use App\Value\ShoppingList;
use App\Value\SIUnit;
use App\Value\User;
use FactoryTestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShoppingListFactoryTest extends FactoryTestCase
{
    private ShoppingListFactory $shoppingListFactory;
    private ?ShoppingList $shoppingList;
    private User $testUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->testUser = $this->generateTestUser();
        $this->shoppingListFactory = $this->app->make(ShoppingListFactory::class);
    }

    public function tearDown(): void
    {
        if ($this->shoppingList !== null) {
            $this->shoppingListFactory->deleteShoppingList($this->shoppingList);
        }

        parent::tearDown();
    }

    /** @test */
    public function it_tests_adding_shopping_list(): ShoppingList
    {
        $shoppingList = $this->shoppingListFactory->addItemsToShoppingList(
            $this->testUser,
            $this->generateIngredients()
        );
        $shoppingListFromDao = $this->shoppingListFactory->fromId($shoppingList->id());
        $this->shoppingList = $shoppingListFromDao;

        $this->assertEquals($shoppingList, $shoppingListFromDao);
        $this->assertEquals($shoppingList->ingredients()->toArray(), $shoppingListFromDao->ingredients()->toArray());
        $this->assertEquals(4, $shoppingList->ingredients()->count());

        return $shoppingList;
    }

    /** @test */
    public function it_tests_deleting_shopping_list()
    {
        $list = $this->it_tests_adding_shopping_list();
        $this->shoppingListFactory->deleteShoppingList($list);

        $exceptionThrown = false;
        try {
            $this->shoppingListFactory->fromId($list->id());
        } catch (ModelNotFoundException $exception) {
            $exceptionThrown = true;
        }

        if ($exceptionThrown) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }

        $this->shoppingList = null;
    }

    /** @test */
    public function it_tests_receiving_list_for_user()
    {
        $list = $this->it_tests_adding_shopping_list();

        $listForUser = $this->shoppingListFactory->forUser($this->testUser);

        $this->assertEquals($list, $listForUser);
    }

    /** @test */
    public function it_tests_updating_ingredients_by_increasing_amount_of_existing_ingredient()
    {
        $this->it_tests_adding_shopping_list();
        $newIngredient = new Ingredient("Butter", 200, SIUnit::g(), 100);
        $newIngredientSet = IngredientsSet::fromArray([$newIngredient]);
        $resultList = $this->shoppingListFactory->addItemsToShoppingList($this->testUser, $newIngredientSet);
        $resultIngredients = $resultList->ingredients()->toArray();

        $this->assertCount(4, $resultIngredients);
        $this->assertEquals("Butter", $resultIngredients[3]['name']);
        $this->assertEquals(400, $resultIngredients[3]['amount']);
    }

    /** @test */
    public function it_tests_updating_ingredients_by_creating_new_shopping_list()
    {
        $newIngredient = new Ingredient("Butter", 200, SIUnit::g(), 100);
        $newIngredientSet = IngredientsSet::fromArray([$newIngredient]);
        $resultList = $this->shoppingListFactory->addItemsToShoppingList($this->testUser, $newIngredientSet);
        $this->shoppingList = $resultList;
        $resultIngredients = $resultList->ingredients()->toArray();

        $this->assertCount(1, $resultIngredients);
        $this->assertEquals("Butter", $resultIngredients[0]['name']);
        $this->assertEquals(200, $resultIngredients[0]['amount']);
    }

    /** @test */
    public function it_tests_adding_ingredients_when_shopping_list_is_empty()
    {
        $newIngredientSet = IngredientsSet::fromArray([]);
        $emptyList = $this->shoppingListFactory->addItemsToShoppingList($this->testUser, $newIngredientSet);
        $this->assertEquals(0, $emptyList->ingredients()->count());

        $this->it_tests_adding_shopping_list();
    }

    /** @test */
    public function it_tests_adding_more_ingredients_than_existing()
    {
        $newIngredient = new Ingredient("Safran", 200, SIUnit::g(), 100);
        $newIngredientSet = IngredientsSet::fromArray([$newIngredient]);
        $this->shoppingListFactory->addItemsToShoppingList($this->testUser, $newIngredientSet);

        $shoppingList = $this->shoppingListFactory->addItemsToShoppingList(
            $this->testUser,
            $this->generateIngredients()
        );
        $shoppingListFromDao = $this->shoppingListFactory->fromId($shoppingList->id());
        $this->shoppingList = $shoppingListFromDao;

        $this->assertEquals(5, $this->shoppingList->ingredients()->count());
    }

    /** @test */
    public function it_tests_removing_ingredient()
    {
        $list = $this->it_tests_adding_shopping_list();
        $ingredientToDelete = new Ingredient("Butter", 200, SIUnit::g(), 100);
        $this->shoppingListFactory->deleteItem($list, $ingredientToDelete);

        $list = $this->shoppingListFactory->fromId($list->id());

        $this->assertEquals(3, $list->ingredients()->count());
        $this->assertFalse($list->ingredients()->contains($ingredientToDelete));
    }
}
