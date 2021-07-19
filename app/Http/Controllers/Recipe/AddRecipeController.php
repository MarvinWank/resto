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
    public function add(Request $request, RecipeFactory $recipeFactory, UserFactory $userFactory): JsonResponse
    {
        $data = $request->json()->all();
        $data = AddRecipeRequestDto::fromArray($data['recipe']);
        $user = $userFactory->currentUser();

        $recipe = $recipeFactory->addRecipe(
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
