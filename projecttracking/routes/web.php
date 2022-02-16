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

// Route::get('/', function () {
// 	return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')
    ->name('home')
    ->middleware('auth');

Route::get('/home', 'HomeController@index')
    ->middleware('auth');

// CRUD Customer
Route::get('/customer',                         'CustomerController@index');
Route::get('/customer/create',                  'CustomerController@create');
Route::post('/customer/created',                'CustomerController@store');
Route::get('/customer/{vat_number}',            'CustomerController@show');
Route::patch('/customer/{vat_number}',          'CustomerController@update');
Route::get('/customer/{vat_number}/delete',     'CustomerController@destroy');
Route::get('/customer/{vat_number}/edit',       'CustomerController@edit');

Route::post('/customer',                        'CustomerController@search');

// CRUD Project
Route::get('/project',                          'ProjectController@index');
Route::get('/project/create',                   'ProjectController@create');
Route::post('/project/created',                 'ProjectController@store');
Route::get('/project/{id}',                     'ProjectController@show');
Route::patch('/project/{id}',                   'ProjectController@update');
Route::get('/project/{id}/delete',              'ProjectController@destroy');
Route::get('/project/{id}/edit',                'ProjectController@edit');

Route::get('/project/{id}/terminate',           'ProjectController@terminate');
Route::post('/project',                         'ProjectController@search');

// CRUD WorkingOn
//Route::get('/working_on/create',                'WorkingOnController@create');
Route::post('/working_on',                      'WorkingOnController@store');
Route::get('/working_on/{id}/delete',           'WorkingOnController@destroy');

// CRUD Timesheet
Route::post('/timesheet',                                   'TimesheetController@store');
Route::patch('/timesheet/{id}',                             'TimesheetController@update');
Route::get('/timesheet/{id}/edit',                          'TimesheetController@edit');
Route::get('/timesheet/{id}/delete',                        'TimesheetController@destroy');

Route::get('/timesheet/showWorkOn/{user_id}/{project_id}',  'TimesheetController@showWorkOn');
Route::post('/timesheet/projectsReport',                    'TimesheetController@setProjectsDates');
Route::get('/timesheet/projectsReport/{start}/{end}',       'TimesheetController@projectsReport');
Route::post('/timesheet/customersReport',                   'TimesheetController@setCustomersDates');
Route::get('/timesheet/customersReport/{start}/{end}',      'TimesheetController@customersReport');
Route::post('/timesheet/monthlyRecap',                      'TimesheetController@setRecapMonth');
Route::get('/timesheet/monthlyRecap/{month}',               'TimesheetController@monthlyRecap');

// CRUD User
Route::get('/user',                             'UserController@index');
Route::get('/user/create',                      'UserController@create');
Route::post('/user/created',                    'UserController@store');
Route::get('/user/{id}',                        'UserController@show');
Route::patch('/user/{id}',                      'UserController@update');
Route::get('/user/{id}/delete',                 'UserController@destroy');
Route::get('/user/{id}/edit',                   'UserController@edit');

Route::get('/user/{id}/setAdmin',               'UserController@setAdmin');
Route::get('/user/{id}/removeAdmin',            'UserController@removeAdmin');
Route::post('/user',                            'UserController@search');
