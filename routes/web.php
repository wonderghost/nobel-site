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

Route::get('/','PagesController@index');
Route::get('/section/{slug}','PagesController@ourServices');
Route::post('/service/getinfos-service','PagesController@getInfosService');
Route::post('/contact-us','ContactController@sendContactForm');
// Route::get('/')
Route::get('/get-section','PagesController@getSection');

Auth::routes();
Route::post('/log-in','Auth\LoginController@logIn');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/get-sections','HomeController@getSection');
    Route::post('/add-sous-section','HomeController@addSousSection');
    Route::post('/edit-sous-section','HomeController@makeEditRequest');
});