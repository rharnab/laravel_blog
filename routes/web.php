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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', 'HomeController@index')->name('home');

Route::post('subscriber', 'SubscriberController@store')->name('subscriber.store');
Route::get('post/{slug}', 'PostController@post_details')->name('post.details');
Route::get('posts', 'PostController@index')->name('post.index');
Route::get('category/{slug}', 'PostController@categoryByPost')->name('category.post');
Route::get('tag/{slug}', 'PostController@tagByPost')->name('tag.post');
Route::get('search', 'SearchController@search')->name('search.post');
Route::get('author-profile/{user_name}', 'AuthorController@author_profile')->name('author.profile');

Auth::routes();
Route::group(['middleware'=>'auth'], function(){

	Route::post('favorite/{post}/add', 'FavouriteController@add')->name('post.favorite');
	Route::post('comment/{post}', 'CommentController@store')->name('comment.store');
});
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['as'=>'admin.','prefix'=>'admin', 'namespace'=>'Admin','middleware'=>['auth', 'admin']], function(){

	Route::get('dashboard', 'DashboardController@index')->name('dashboard');
	Route::get('favorite', 'favoriteController@index')->name('favorite');
	Route::get('author', 'AuthorController@index')->name('author.index');
	Route::Delete('author{id}/', 'AuthorController@destroy')->name('author.destroy');

	Route::get('setting', 'SettingController@index')->name('setting');
	Route::post('profile-update', 'SettingController@profile_update')->name('profile.update');
	Route::post('password-update', 'SettingController@password_update')->name('password.update');
	
	Route::resource('tag', 'TagController');
	Route::resource('category', 'CategoryController');
	Route::resource('post', 'PostController');
	Route::get('pending/post', 'PostController@pending')->name('post.pending');
	Route::post('post/{id}/approval', 'PostController@approval')->name('post.approve');
	Route::get('subscriber', 'SubscriberController@index')->name('subscribe.index');
	Route::delete('subscriber-delete/{id}', 'SubscriberController@destroy')->name('subscribe.destroy');


});


Route::group(['as'=>'author.','prefix'=>'author', 'namespace'=>'Author','middleware'=>['auth', 'author']], function(){

	Route::get('dashboard', 'DashboardController@index')->name('dashboard');
	Route::get('favorite', 'favoriteController@index')->name('favorite');

	Route::get('setting', 'SettingController@index')->name('setting');
	Route::post('profile-update', 'SettingController@profile_update')->name('profile.update');
	Route::post('password-update', 'SettingController@password_update')->name('password.update');
	
	Route::resource('post', 'PostController');
});
