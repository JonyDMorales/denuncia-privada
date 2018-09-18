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

    Route::post('agregar', 'UserController@agregarCampo')->name('agregar');
    Route::post('post', 'UserController@cambiarPost')->name('post');


    Route::get('facebook', 'UserController@postFacebook')->name('facebook');

    Route::get('filtro', 'DenunciaController@filtro')->name('filtro');
    Route::get('registrar', 'DenunciaController@registrar')->name('registrar');
    Route::get('denuncias', 'DenunciaController@denuncias')->name('denuncias');
    Route::get('mapa', 'DenunciaController@mapa')->name('mapa');
    Route::get('configuraciones', 'UserController@configuracion')->name('configuraciones');
});