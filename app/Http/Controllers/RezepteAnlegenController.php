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
        $data = AddRecipeRequestDto::fromArray($data);

        $user = $userFactory->current_user();

        $recipe = $recipeFactory->add_recipe(
            $user,
            $data->title(),
            DietStyle::fromName($data->dietStyle()),
            Cuisine::fromName($data->cuisine()),
            $data->timeToPrepare(),
            600,
            $data->ingredients()
        );


        return response()->json([
            "status" => "ok",
            "recipe" => $recipe->toArray(),
        ]);
    }
}
