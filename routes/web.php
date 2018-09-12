<?php

Auth::routes();
Route::get('/', function (){
    return view('auth.login');
});

Route::get('home', 'HomeController@index')->name('home');


Route::prefix('admin')->middleware('auth')->group(function() {

    //Filtro
    Route::post('aprobar', 'DenunciaController@aprobarDenuncia')->name('aprobar');
    Route::post('rechazar', 'DenunciaController@rechazarDenuncia')->name('rechazar');

    Route::post('registrar', 'UserController@insertar')->name('registrar');
    Route::post('email', 'DenunciaController@enviarEmail');

    Route::get('filtro', 'DenunciaController@filtro')->name('filtro');
    Route::get('registrar', 'DenunciaController@registrar')->name('registrar');
    Route::get('denuncias', 'DenunciaController@denuncias')->name('denuncias');
    Route::get('mapa', 'DenunciaController@mapa')->name('mapa');
});