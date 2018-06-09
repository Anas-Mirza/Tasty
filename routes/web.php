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
/*search routes*/
Route::get('/search','SearchController@index')->name('search');
Route::get('/search/{id}','SearchController@show')->name('search_show');
Route::post('/results','SearchController@results')->name('result');
/*myrecipe routes*/
Route::get('/myrecipes','MyRecipeController@index')->name('myrecipes');
Route::get('/myrecipes/{id}','MyRecipeController@show')->name('myrecipes_show');
Route::post('/myrecipes/save','MyRecipeController@store')->name('myrecipes_save');
Route::delete('/myrecipes/remove{recipe}','MyRecipeController@remove')->name('myrecipes_remove');
/*planner routes*/
Route::get('/planner','PlannerController@index')->name('planner');
Route::get('/planner/plan/{date}','PlannerController@plan')->name('planner_plan');
Route::post('/planner/add','PlannerController@add')->name('planner_add');
Route::delete('/planner/remove/{meal}','PlannerController@remove')->name('planner_remove');
/*shopping routes*/
Route::get('/shop','ShoppingController@index')->name('shopping');