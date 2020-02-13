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

Route::get('/Admin/home', 'HomeController@index1')->name('home')->middleware(Admin::class);
Route::get('adminHome', 'HomeController@index2')->name('userhome');

//CATEGORY
Route::resource('category/master', 'Category\CategoryController');
Route::resource('category/Category', 'Category\Category');
Route::get('/category/Category', 'Category\Category@index')->name('Cindex');
Route::post('/category/Category', 'Category\Category@store')->name('Cstore');
Route::post('category/update', 'Category\Category@update')->name('categoryupdate');
Route::get('category/destroy/{id}', 'Category\Category@destroy');
Route::get('/category/trashcategory', 'Category\Category@trashindex')->name('Ctrash');
Route::get('category/restore/{id}', 'Category\Category@restore');




//ITEM
Route::resource('Item/Item', 'Item\ItemController');
Route::get('/Item/Item', 'Item\ItemController@index')->name('Iindex');
Route::post('/Item/Item', 'Item\ItemController@store')->name('Istore');
Route::post('Item/update', 'Item\ItemController@update')->name('Iupdate');
Route::get('Item/destroy/{id}', 'Item\ItemController@destroy');

Route::get('/Item/trashitem', 'Item\ItemController@trashindex')->name('Itrash');
Route::get('Item/restore/{id}', 'Item\ItemController@restore');











