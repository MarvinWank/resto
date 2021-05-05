<?php


namespace factories;


use App\Factories\ShoppingListFactory;
use App\Value\Ingredient;
use App\Value\IngredientsSet;
use App\Value\ShoppingList;
use App\Value\SIUnit;
use FactoryTestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShoppingListFactoryTest extends FactoryTestCase
{
    private ShoppingListFactory $shoppingListFactory;
    private ?ShoppingList $shoppingList;

    public function setUp(): void
    {
        parent::setUp();

        $this->shoppingListFactory = $this->app->make(ShoppingListFactory::class);
    }

    public function tearDown(): void
    {
        if ($this->shoppingList !== null){
            $this->shoppingListFactory->deleteShoppingList($this->shoppingList);
        }

        parent::tearDown();
    }

    /** @test */
    public function it_tests_adding_shopping_list(): ShoppingList
    {
        $shoppingList = $this->shoppingListFactory->addShoppingList(
            $this->testUser,
            $this->generateIngredients()
        );
        $shoppingListFromDao = $this->shoppingListFactory->fromId($shoppingList->id());
        $this->shoppingList = $shoppingListFromDao;

        $this->assertEquals($shoppingList, $shoppingListFromDao);

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
        }catch (ModelNotFoundException $exception){
            $exceptionThrown = true;
        }

        if ($exceptionThrown){
            $this->assertTrue(true);
        }else{
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
        $resultList = $this->shoppingListFactory->addItemsToShoppingList($this->testUser,$newIngredientSet);
        $resultIngredients = $resultList->ingredients()->toArray();

        $this->assertCount(4, $resultIngredients);
        $this->assertEquals("Butter",$resultIngredients[0]['name']);
        $this->assertEquals(400,$resultIngredients[0]['amount']);
    }

}
