<?php

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');


Route::prefix('admin')->middleware('auth')->group(function() {
    Route::post('registrar', 'UserController@insertar')->name('registrar');
    //Filtro
    Route::get('/filtro', 'DenunciaController@filtro')->name('filtro');
    Route::post('aprobar', 'DenunciaController@aprobarDenuncia')->name('aprobar');
    Route::post('rechazar', 'DenunciaController@rechazarDenuncia')->name('rechazar');

    Route::get('/denuncias', 'DenunciaController@denuncias')->name('denuncias');
    Route::get('/mapa', 'DenunciaController@mapa')->name('mapa');

    Route::post('email', 'DenunciaController@enviarEmail');
});