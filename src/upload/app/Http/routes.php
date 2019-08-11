<?php

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

$app->get('/', 'WellcomeController@index');
$app->group(['prefix' => env('API_VERSION'), 'namespace' => 'App\Http\Controllers'], function ($app) {
    $app->post('upload', ['middleware' => 'apikey','uses' => 'UploadController@upload']);
    $app->get('file/{uuid}', 'UploadController@download');
});
