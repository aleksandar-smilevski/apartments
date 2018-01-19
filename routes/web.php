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



Route::get('/',"Controller@index");

Route::get('/apartments',"ApartmentsController@getByLocation");
Route::get('/apartments/save', 'ApartmentsController@save')->middleware('auth');
Route::get('/apartments/edit/{id}', 'ApartmentsController@edit')->middleware('auth');
Route::post('/apartments/update/{id}', 'ApartmentsController@update')->middleware('auth');
Route::get('/apartments/{id}',"ApartmentsController@show");
Route::post('/apartments', "ApartmentsController@create")->name('create')->middleware('auth');

Route::get('/reservations',"ReservationsController@index");
Route::get('/reservations/{id}',"ReservationsController@show");
Route::get('/apartments/{apartmentId}/reservations',"ReservationsController@listAllForApartment");
Route::get('/apartments/{apartmentId}/reservations/{reservationId}',"ReservationsController@showForApartment");

Route::get('/users',"UsersController@index");
Route::get('/users/{id}',"UsersController@show");



Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
