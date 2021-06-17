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
    $router->get('/{id}', 'ProjetoController@detalhes');
    $router->put('/{id}', 'ProjetoController@update');
    $router->delete('/{id}', 'ProjetoController@delete');
});

$router->group(['prefix' => 'forum'], function() use ($router) {
    $router->get('/', 'PostagemController@index');
    $router->post('/', 'PostagemController@new');
    $router->get('/{id}', 'PostagemController@detalhes');
    $router->put('/{id}', 'PostagemController@update');
    $router->delete('/{id}', 'PostagemController@delete');
    $router->get('/{id}/comments', 'ComentarioController@detalhes');
    $router->post('/{id}', 'ComentarioController@new');
    $router->put('/{post_id}/comments/{comment_id}', 'ComentarioController@update');
    $router->delete('/{post_id}/comments/{comment_id}', 'ComentarioController@delete');
});
