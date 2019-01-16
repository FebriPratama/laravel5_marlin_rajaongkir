<?php

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


Route::prefix('book')->group(function () {

	Route::get('/', 'BookController@view_book_data')->name('view_book');
	Route::post('/', 'BookController@add_book_proses')->name('add_book');
	Route::post('/{id}/update', 'BookController@update_book_proses')->name('update_book');
	Route::get('/{id}/delete', 'BookController@delete_book_proses')->name('delete_book');
	Route::get('/delete', 'BookController@delete_multi_book_proses')->name('delete_multi_book');

});

Route::prefix('category')->group(function () {

	Route::get('/', 'CatController@view_cat_data')->name('view_cat');
	Route::post('/', 'CatController@add_cat_proses')->name('add_cat');
	Route::post('/{id}/update', 'CatController@update_cat_proses')->name('update_cat');
	Route::get('/{id}/delete', 'CatController@delete_cat_proses')->name('delete_cat');
	Route::get('/delete', 'CatController@delete_multi_cat_proses')->name('delete_multi_cat');

});