<?php


namespace factories;


use App\Daos\RecipeDao;
use App\Exceptions\RecipeNotFoundException;
use App\Factories\RecipeFactory;
use App\Value\Cuisine;
use App\Value\DietStyle;
use App\Value\Ingredient;
use App\Value\IngredientsSet;
use App\Value\Recipe;
use App\Value\SIUnit;

class RecipeFactoryTest extends \FactoryTestCase
{
    private RecipeFactory $recipeFactory;

    public function setUp(): void
    {
        parent::setUp();
        $this->recipeFactory = app(RecipeFactory::class);
    }

    public function tearDown(): void
    {
        /** @var RecipeDao $recipeDao */
        $recipeDao = app(RecipeDao::class);
        $recipeDao->deleteForUser($this->test_user);
        parent::tearDown();
    }

    /**
     * @test
     */
    public function es_testet_speichern_und_holen_eines_rezepts()
    {
        $ingredients = IngredientsSet::fromArray([
            new Ingredient("Butter", 200, SIUnit::g(), 100),
            new Ingredient("Schmalz", 200, SIUnit::g(), 100),
            new Ingredient("Milch", 200, SIUnit::g(), 100),
            new Ingredient("Mehl", 200, SIUnit::g(), 100),
        ]);
        $recipe = $this->recipeFactory->addRecipe(
            $this->test_user,
            "Test Rezept",
            DietStyle::ALLES(),
            Cuisine::DEUTSCH(),
            60,
            90,
            $ingredients,
            "Your add here"
        );

        $this->assertEquals($this->test_user->id(), $recipe->author()->id());
        $this->assertEquals("Test Rezept", $recipe->title());
        $this->assertTrue(DietStyle::ALLES()->equals($recipe->dietStyle()));
        $this->assertTrue(Cuisine::DEUTSCH()->equals($recipe->cuisine()));
        $this->assertEquals(60, $recipe->timeToCook());
        $this->assertEquals(90, $recipe->totalTime());
        $this->assertEquals(["name" => "Butter", "amount" => 200.0, "unit" => "g", "kcal" => 100], $recipe->ingredients()->toArray()[0]);
        $this->assertEquals("Your add here", $recipe->description());
    }

    /**
     * @test
     */
    public function it_tests_give_all_for_user()
    {
        $ingredients = IngredientsSet::fromArray([
            new Ingredient("Butter", 200, SIUnit::g(), 100),
            new Ingredient("Schmalz", 200, SIUnit::g(), 100),
            new Ingredient("Milch", 200, SIUnit::g(), 100),
            new Ingredient("Mehl", 200, SIUnit::g(), 100),
        ]);
        $this->recipeFactory->addRecipe(
            $this->test_user,
            "Test Rezept",
            DietStyle::ALLES(),
            Cuisine::DEUTSCH(),
            60,
            90,
            $ingredients,
            "Your add here"
        );
        $this->recipeFactory->addRecipe(
            $this->test_user,
            "Test Rezept 2",
            DietStyle::VEGAN(),
            Cuisine::ASIATISCH(),
            60,
            90,
            $ingredients,
            "Your add here"
        );

        $allRecipes = $this->recipeFactory->getAllRecipesForUser($this->test_user);
        /** @var Recipe $recipe1 */
        $recipe1 = $allRecipes->toArray()[0];
        /** @var Recipe $recipe2 */
        $recipe2 = $allRecipes->toArray()[1];

        $this->assertEquals("Test Rezept", $recipe1['title']);
        $this->assertEquals("Test Rezept 2", $recipe2['title']);
    }

    /**
     * @test
     */
    public function it_tests_give_top_recipes_for_user()
    {
        $ingredients = IngredientsSet::fromArray([
            new Ingredient("Butter", 200, SIUnit::g(), 100),
            new Ingredient("Schmalz", 200, SIUnit::g(), 100),
            new Ingredient("Milch", 200, SIUnit::g(), 100),
            new Ingredient("Mehl", 200, SIUnit::g(), 100),
        ]);
        $this->recipeFactory->addRecipe(
            $this->test_user,
            "Test Rezept",
            DietStyle::ALLES(),
            Cuisine::DEUTSCH(),
            60,
            90,
            $ingredients,
            "Your add here"
        );
        $this->recipeFactory->addRecipe(
            $this->test_user,
            "Test Rezept 2",
            DietStyle::VEGAN(),
            Cuisine::ASIATISCH(),
            60,
            90,
            $ingredients,
            "Your add here"
        );
        $this->recipeFactory->addRecipe(
            $this->test_user,
            "Test Rezept 2",
            DietStyle::VEGAN(),
            Cuisine::ASIATISCH(),
            60,
            90,
            $ingredients,
            "Your add here"
        );

        $recipes = $this->recipeFactory->getTopRecipesForUser($this->test_user, 2);
        $this->assertEquals(2, $recipes->count());

        $allRecipes = $this->recipeFactory->getAllRecipesForUser($this->test_user);
        $this->assertEquals(3, $allRecipes->count());
    }

    /**
     * @test
     */
    public function it_tests_sucessfully_get_recipe_by_id(): Recipe
    {
        $ingredients = IngredientsSet::fromArray([
            new Ingredient("Butter", 200, SIUnit::g(), 100),
            new Ingredient("Schmalz", 200, SIUnit::g(), 100),
            new Ingredient("Milch", 200, SIUnit::g(), 100),
            new Ingredient("Mehl", 200, SIUnit::g(), 100),
        ]);
        $recipe = $this->recipeFactory->addRecipe(
            $this->test_user,
            "Test Rezept",
            DietStyle::ALLES(),
            Cuisine::DEUTSCH(),
            60,
            90,
            $ingredients,
            "Your add here"
        );

        $recipeFromId = $this->recipeFactory->fromId($recipe->id());
        $this->assertEquals($recipe, $recipeFromId);

        return $recipe;
    }

    /**
     * @test
     */
    public function it_tests_delete_recipe()
    {
        $recipe = $this->it_tests_sucessfully_get_recipe_by_id();
        $this->recipeFactory->delete($recipe->id());

        $this->expectException(RecipeNotFoundException::class);
        $this->recipeFactory->fromId($recipe->id());
    }

    /**
     * @throws RecipeNotFoundException
     * @test
     */
    public function it_tests_update_recipe()
    {
        $recipe = $this->it_tests_sucessfully_get_recipe_by_id();
        $alteredIngredients = IngredientsSet::fromArray([  new Ingredient("Schmalz", 200, SIUnit::g(), 100)]);

        $updatedRecipe = $recipe
            ->with_title("New title")
            ->with_cuisine(Cuisine::INDISCH())
            ->with_description("qwertzuiop")
            ->with_dietStyle(DietStyle::VEGAN())
            ->with_ingredients($alteredIngredients)
            ->with_timeToCook(2)
            ->with_totalTime(3);
        $resultRecipe = $this->recipeFactory->update($updatedRecipe, $recipe->id());


        $this->assertEquals($updatedRecipe->toArray(), $resultRecipe->toArray());
    }
}
