<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    /** @var \GuzzleHttp\Client $client */
    $client = app('GuzzleClient')([]);
//        $response = $client->get('http://zcraig.me/foo', ['json' => ['foo' => ['bar' => 'baz']]]);
    $response = $client->post('http://zcraig.me/foo', ['body' =>  'bar']);
    return $response->getBody()->getContents();
});
