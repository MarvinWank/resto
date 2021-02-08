<?php


namespace App\Http\Controllers\Recipe;


use App\Factories\RecipeFactory;
use App\Factories\UserFactory;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Value\AddRecipeRequestDto;
use App\Value\Cuisine;
use App\Value\DietStyle;
use Illuminate\Http\Request;

class AddRecipeController extends Controller
{
    public function add(Request $request, RecipeFactory $recipeFactory, UserFactory $userFactory)
    {
        $data = $request->json()->all();
        $data = AddRecipeRequestDto::fromArray($data['recipe']);
        $user = $userFactory->currentUser();

        $recipe = $recipeFactory->add_recipe(
            $user,
            $data->title(),
            DietStyle::fromValue($data->dietStyle()),
            Cuisine::fromValue($data->cuisine()),
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
