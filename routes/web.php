<?php

/*
 *
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*
 */


/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\Friends\SearchUsersController;

$router->group(['prefix' => 'api'], function () use ($router) {

    //You can't have an API-Key if you're not logged in
    $router->post('/login', 'LoginController@login');
    //Or registered
    $router->post('/register', 'RegisterController@register');

    $router->group(["middleware" => "checkApiKey"], function () use ($router) {
        $router->post('/login_with_api_key', 'LoginController@login_with_api_key');

        //Recipes
        $router->post('/recipes/add', 'Recipe\AddRecipeController@add');
        $router->post('/recipes/all', 'Recipe\GetRecipesController@getAll');
        $router->post('/recipes/top', 'Recipe\GetRecipesController@getTop');
        $router->post('/recipes/get_by_id', 'Recipe\GetRecipeByIdController@get');
        $router->post('/recipes/update', 'Recipe\UpdateRecipeController@updateRecipe');
        $router->post("/recipes/delete", 'Recipe\DeleteRecipeController@delete');
        $router->post("/recipes/search/sayt", 'Search\SearchSaytController@saytList');

        // Shopping List
        $router->post('/list/add_items', 'ShoppingList\AddItemsController@addItems');
        $router->post('/list/delete_items', 'ShoppingList\RemoveItemsController@removeIngredients');

        $router->group(['prefix' => 'friends'], function () use ($router) {
            $router->get('search', [SearchUsersController::class, 'handle']);
        });

    });
});

