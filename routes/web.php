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

Route::get('/', 'WebsiteController@index')->name('index');
Route::get('post/{slug}', 'WebsiteController@post')->name('post');;
Route::get('tag/{id}', 'WebsiteController@tag')->name('tag');;

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/posts', 'PostsController@listar')->name('posts.index');
Route::get('/posts/create', 'PostsController@criar');
Route::post('/posts/store', 'PostsController@salvar')->name('posts.store');
Route::get('/posts/edit/{slug}', 'PostsController@editar');
Route::post('/posts/update/{slug}', 'PostsController@atualizar')->name('posts.update');;
Route::get('/posts/destroy/{slug}', 'PostsController@deletar');
