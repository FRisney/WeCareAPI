<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// route to retrieve api documentation from the current version
$router->get('/docs.json', function() {
    return (new Response( Storage::get('openapi.json'), 200))
        ->header('Content-Type', 'application/json');
});

$router->group(['prefix' => 'users'], function() use ($router) {
    $router->get('/', 'UsuarioController@index');
    $router->post('/', 'UsuarioController@new');
    $router->get('/{id}', 'UsuarioController@perfil');
    $router->put('/{id}', 'UsuarioController@update');
    $router->delete('/{id}', 'UsuarioController@delete');
});

$router->group(['prefix' => 'projetos'], function() use ($router) {
    $router->get('/', 'ProjetoController@index');
    $router->post('/', 'ProjetoController@new');
    $router->get('/{id}', 'ProjetoController@perfil');
    $router->put('/{id}', 'ProjetoController@update');
    $router->delete('/{id}', 'ProjetoController@delete');
});
