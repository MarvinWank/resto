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


/** @var Router $router */

use App\Http\Controllers\Friends\SearchUsersController;
use Laravel\Lumen\Routing\Router;

$router->group(['prefix' => 'api'], function () use ($router) {

    //You can't have an API-Key if you're not logged in
    $router->post('/login', 'LoginController@handle');
    //Or registered
    $router->post('/register', 'RegisterController@handle');

    $router->group(["middleware" => "checkApiKey"], function () use ($router) {
        $router->post('/login_with_api_key', 'LoginController@handle');

        //Recipes
        $router->post('/recipes/add', 'Recipe\AddRecipeController@handle');
        $router->post('/recipes/all', 'Recipe\GetRecipesController@handle');
        $router->post('/recipes/top', 'Recipe\GetRecipesController@handle');
        $router->post('/recipes/get_by_id', 'Recipe\GetRecipeByIdController@handle');
        $router->post('/recipes/update', 'Recipe\UpdateRecipeController@handle');
        $router->post("/recipes/delete", 'Recipe\DeleteRecipeController@handle');
        $router->post("/recipes/search/sayt", 'Search\SearchSaytController@handle');

        // Shopping List
        $router->post('/list/add_items', 'ShoppingList\AddItemsController@handle');
        $router->post('/list/delete_items', 'ShoppingList\RemoveItemsController@handle');

        $router->group(['prefix' => 'friends'], function () use ($router) {
            $router->get('search', [SearchUsersController::class, 'handle']);
        });

    });
});

