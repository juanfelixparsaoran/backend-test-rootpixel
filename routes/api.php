<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['web']], function () {
    // your routes here
});
Route::resource('user', 'UserController');
Route::resource('post', 'PostController');
Route::resource('comment', 'CommentController');
Route::post('user/login', 'UserController@login');
Route::get('checkauth', 'UserController@checkAuth');
Route::post('checkusername', 'UserController@checkUsername');
Route::get('logout','UserController@logout');
Route::get('post/userpost/{id}','PostController@userpost');
Route::get('comment/postcomment/{id}','CommentController@postcomment');
