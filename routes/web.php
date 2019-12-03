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

Auth::routes(['verify' => true, 'register' => false]);

Route::middleware(['auth'])
    ->group(function(){

        Route::resource('kkm', 'KKMController')->only([
            'index', 'show'
        ]);

        Route::post('reports', 'ReportController@index')->name('reports.index');

        Route::get('/home', 'HomeController@index')->name('home');

    });

