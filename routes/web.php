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
$router->group(['prefix' => 'api'], function () use ($router) {

    //You can't have an API-Key if you're not logged in
    $router->post('/login', 'LoginController@login');

    $router->group(["middleware" => "checkApiKey"], function () use ($router) {
        $router->post('/recipes/add', 'Recipe\AddRecipeController@add');
        $router->post('/recipes/all', 'Recipe\GetRecipesController@getAll');
        $router->post('/recipes/top', 'Recipe\GetRecipesController@getTop');
        $router->post('/recipes/get_by_id', 'Recipe\GetRecipeByIdController@get');
    });
});

