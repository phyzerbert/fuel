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
    return redirect(route('login'));
});

Auth::routes();

Route::any('/home', 'HomeController@index')->name('home');


Route::any('/unloading/index', 'UnloadingController@index')->name('unloading.index');
Route::post('/unloading/create', 'UnloadingController@create')->name('unloading.create');
Route::post('/unloading/edit', 'UnloadingController@edit')->name('unloading.edit');
Route::get('/unloading/delete/{id}', 'UnloadingController@delete')->name('unloading.delete');


Route::any('/filling/index', 'FillingController@index')->name('filling.index');
Route::post('/filling/create', 'FillingController@create')->name('filling.create');
Route::post('/filling/edit', 'FillingController@edit')->name('filling.edit');
Route::get('/filling/delete/{id}', 'FillingController@delete')->name('filling.delete');

Route::get('/profile', 'UserController@profile')->name('profile');
Route::post('/updateuser', 'UserController@updateuser')->name('updateuser');
Route::any('/users/index', 'UserController@index')->name('users.index');
Route::post('/user/create', 'UserController@create')->name('user.create');
Route::post('/user/edit', 'UserController@edituser')->name('user.edit');
Route::get('/user/approve/{id}', 'UserController@approve')->name('user.approve');
Route::get('/user/delete/{id}', 'UserController@delete')->name('user.delete');

Route::any('/unit/index', 'UnitController@index')->name('unit.index');
Route::post('/unit/create', 'UnitController@create')->name('unit.create');
Route::post('/unit/edit', 'UnitController@edit')->name('unit.edit');
Route::get('/unit/delete/{id}', 'UnitController@delete')->name('unit.delete');

Route::any('/fuel/index', 'FuelController@index')->name('fuel.index');
Route::post('/fuel/create', 'FuelController@create')->name('fuel.create');
Route::post('/fuel/edit', 'FuelController@edit')->name('fuel.edit');
Route::get('/fuel/delete/{id}', 'FuelController@delete')->name('fuel.delete');

Route::any('/vehicle/index', 'VehicleController@index')->name('vehicle.index');
Route::post('/vehicle/create', 'VehicleController@create')->name('vehicle.create');
Route::post('/vehicle/edit', 'VehicleController@edit')->name('vehicle.edit');
Route::get('/vehicle/delete/{id}', 'VehicleController@delete')->name('vehicle.delete');

Route::any('/tank/index', 'TankController@index')->name('tank.index');
Route::post('/tank/create', 'TankController@create')->name('tank.create');
Route::post('/tank/edit', 'TankController@edit')->name('tank.edit');
Route::get('/tank/delete/{id}', 'TankController@delete')->name('tank.delete');


Route::post('/set_pagesize', 'HomeController@set_pagesize')->name('set_pagesize');
