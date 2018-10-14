<?php
use ProximaFecha\Core\Route;

Route::addRoute('GET' , '/'                              , 'HomeController@index');
Route::addRoute('POST', '/validar_ingreso'               , 'UsuarioController@loguear');
Route::addRoute('GET' , '/desloguear'                    , 'UsuarioController@desloguear');
Route::addRoute('GET' , '/usuarios/{usuario_id}'         , 'UsuarioController@ver');


/*
Route::addRoute('POST', '/agregarComentarioPosteos'      , 'HomeController@agregarComentarioPosteos');
Route::addRoute('POST', '/agregarComentario'             , 'HomeController@agregarComentario');
Route::addRoute('GET' , '/error404'                      , 'HomeController@error404');
Route::addRoute('GET' , '/posteos/{usuario_id}'          , 'HomeController@verPosteos');
Route::addRoute('GET' , '/posteos'                       , 'HomeController@index');
Route::addRoute('POST', '/buscar'                        , 'HomeController@buscar');
Route::addRoute('POST', '/registrar'                     , 'UsuarioController@registrar');
Route::addRoute('POST', '/usuarios/actualizarFotoPerfil' , 'UsuarioController@actualizarFotoPerfil');
Route::addRoute('POST', '/usuarios/actualizar'           , 'UsuarioController@actualizar');
Route::addRoute('POST', '/usuarios/crearPosteo'          , 'UsuarioController@crear');
Route::addRoute('GET' , '/chats/{usuario_id}/{amigo_id}' , 'UsuarioController@mostrarChats');
Route::addRoute('POST', '/agregarAmigo'                  , 'UsuarioController@agregarAmigo');
Route::addRoute('POST', '/eliminarAmigo'                 , 'UsuarioController@eliminarAmigo');
Route::addRoute('POST', '/agregarChat'                   , 'UsuarioController@agregarChat');
*/

