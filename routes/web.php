<?php

use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'UserController@edit')->name('profile.edit');



Route::post('/api/profile', 'UserController@update');
Route::get('/api/profile/{user}', 'UserController@show')->name('profile.show');

Route::post('/api/conversations', 'ConversationController@store');

Route::get('/api/messages/{conversation}', 'MessageController@index');
Route::post('/api/messages', 'MessageController@store');

Route::post('/api/invite', 'InvitationController@store');
Route::get('/api/invitations/{user}', 'InvitationController@index');
Route::put('/api/invitations/{invitation}/deny', 'InvitationController@update');

Route::get('/api/conversations/{conversation}/users', 'ConversationUserController@index');
Route::get('/api/users/{user}/conversations', 'UserConversationController@index');
