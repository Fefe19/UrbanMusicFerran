<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\QuevedoMusicController;
use App\Http\Controllers\API\ProductosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login',[UserController::class,'login']);
Route::post('register',[UserController::class,'register']);
Route::post('logout',[UserController::class,'logout'])->middleware(['auth:sanctum']);


Route::get('canciones_categoria', [QuevedoMusicController::class, 'canciones_categoria']);
Route::get('/canciones_categoria/{id_categoria}', [QuevedoMusicController::class, 'getCancionesByCategoria']);



Route::get('categoria', [ProductosController::class, 'categoria']);
Route::get('/categoria/{id_categoria}', [ProductosController::class, 'getProductosByCategoria']);

Route::group(['prefix' => '/', 'middleware' => 'auth:sanctum'], function () {
    Route::get('carrito', [ProductosController::class, 'obtenerProductos']);
    Route::get('precioTotal', [ProductosController::class, 'obtenerPrecioTotal']);
    Route::post('guardar-productos-en-session', [\App\Http\Controllers\API\ProductosController::class, 'guardarProductosSeleccionados']);
    Route::delete('eliminar/{id}', [ProductosController::class,'eliminarProductos']);
    Route::post('pedidos',[ProductosController::class,'pedidos']);
});

Route::group(['prefix' => '/', 'middleware' => 'auth:sanctum'], function () {
    Route::post('addProducto', [ProductosController::class, 'agregarProductos']);
    Route::delete('deleteProducto/{id}', [ProductosController::class, 'delete']);
    Route::post('updateProducto/{id}', [ProductosController::class, 'update']);
    Route::get('editProducto/{id}', [ProductosController::class, 'edit']);
});

Route::group(['prefix' => '/', 'middleware' => 'auth:sanctum'], function () {

    Route::post('updateUsuario/{id}', [UserController::class,'update']);
    Route::delete('deleteUsuario/{id}', [UserController::class,'delete']);

});

Route::group(['prefix' => '/', 'middleware' => 'auth:sanctum'], function () {

    Route::post('addCanciones', [QuevedoMusicController::class, 'agregarCanciones']);
    Route::delete('delete/{id}', [QuevedoMusicController::class,'delete']);
    Route::post('update/{id}', [QuevedoMusicController::class,'update']);
    Route::get('edit/{id}', [QuevedoMusicController::class,'edit']);
   
});


Route::group(['prefix' => '/', 'middleware' => 'auth:sanctum'], function () {
    
    Route::get('canciones', [QuevedoMusicController::class, 'canciones']);
    Route::get('productos',[ProductosController::class,'productos']);
});

//Página usuario administrador
Route::group(['prefix' => 'userAdmin', 'middleware' => 'auth:sanctum'], function () {

    Route::get('/', [UserController::class,'usuarios']);
    Route::delete('delete/{id}', [UserController::class,'deleteUsuarioAdmin']);
    Route::post('update/{id}', [UserController::class, 'editarUsuariosAdmin']);
    Route::post('add', [UserController::class, 'agregarUsuariosAdmin']);
    Route::get('edit/{id}', [UserController::class, 'editUserAdmin']);
    Route::get('roles', [UserController::class, 'getRoles']);

});
 
