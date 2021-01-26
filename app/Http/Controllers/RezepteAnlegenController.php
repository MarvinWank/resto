<?php


namespace App\Http\Controllers;


use App\Factories\RecipeFactory;
use App\Factories\UserFactory;
use App\Models\State;
use App\Value\AddRecipeRequestDto;
use App\Value\Cuisine;
use App\Value\DietStyle;
use Illuminate\Http\Request;

class RezepteAnlegenController extends Controller
{
    public function add(Request $request, State $state, RecipeFactory $recipeFactory, UserFactory $userFactory)
    {
        $data = $request->json()->all();
        $data = AddRecipeRequestDto::fromArray($data['recipe']);

        $user = $userFactory->current_user();


        $recipe = $recipeFactory->add_recipe(
            $user,
            $data->title(),
            DietStyle::fromValue($data->dietStyle()),
            Cuisine::fromValue($data->cuisine()),
            $data->timeToPrepare(),
            $data->ingredients()
        );


        return response()->json([
            "status" => "ok",
            "recipe" => $recipe->toArray(),
        ]);
    }
}
