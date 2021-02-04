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
$router->post('/login', 'LoginController@login');

$router->post('/recipes/add', 'Recipe\AddRecipeController@add');
$router->get('/recipes/all', 'Recipe\GetRecipesController@getAll');
$router->get('/recipes/top', 'Recipe\GetRecipesController@getTop');
$router->get('/recipes/get_by_id', 'Recipe\GetRecipeByIdController@get');
