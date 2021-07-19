<?php


namespace App\Http\Controllers\Recipe;


use App\Factories\RecipeFactory;
use App\Factories\UserFactory;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Value\AddRecipeRequestDto;
use App\Value\Cuisine;
use App\Value\DietStyle;
use App\Value\TypeOfDish;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddRecipeController extends Controller
{
    private RecipeFactory  $recipeFactory;
    private UserFactory  $userFactory;

    public function __construct(RecipeFactory $recipeFactory, UserFactory $userFactory)
    {
        $this->recipeFactory = $recipeFactory;
        $this->userFactory = $userFactory;
    }

    public function handle(Request $request): JsonResponse
    {
        $data = $request->json()->all();
        $data = AddRecipeRequestDto::fromArray($data['recipe']);
        $user = $this->userFactory->currentUser();

        $recipe = $this->recipeFactory->addRecipe(
            $user,
            $data->title(),
            DietStyle::fromName($data->dietStyle()),
            Cuisine::fromName($data->cuisine()),
            TypeOfDish::fromName($data->typeOfDish()),
            $data->timeToCook(),
            $data->totalTime(),
            $data->ingredients(),
            $data->description()
        );


        return response()->json([
            "status" => "ok",
            "recipe" => $recipe->toArray(),
        ]);
    }
}
