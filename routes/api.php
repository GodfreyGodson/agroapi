<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgotPassword', [AuthController::class, 'forgotPassword']);

Route::post('/passwordReset', [AuthController::class, 'passwordReset']);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user',function(){
        return response()->json(Auth::user(), 200);
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::apiResource('/categories', App\Http\Controllers\Category\CategoryController::class);
//Route::apiResource('/products', App\Http\Controllers\Product\ProductController::class);

Route::group(['prefix'=>'categories'], function(){

    Route::apiResource('/{category}/products', App\Http\Controllers\Product\ProductController::class);
    Route::apiResource('/{category}/products/{product}/product-categories', App\Http\Controllers\ProductCategoryController::class);

});
