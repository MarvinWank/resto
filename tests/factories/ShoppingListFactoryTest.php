<?php


namespace factories;


use App\Factories\ShoppingListFactory;
use App\Value\ShoppingList;
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

}
