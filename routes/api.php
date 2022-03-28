<?php


use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CustomerOrderController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ResturantorderController;
use Illuminate\Support\Facades\Route;

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


// Public Routes
Route::get('/product', [ProductController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login' , [AuthController::class, 'login']);




// Protected Route:
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/product', [ProductController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/menu', [MenuController::class, 'store']);
Route::post('/menu/{item}', [MenuController::class, 'show']);

Route::post('/customerorder' , [CustomerOrderController::class, 'store']);
Route::post('/customerorderdetail/{id}', [CustomerOrderController::class, 'show']);

Route::post('/orderdetail/{id}', [ResturantorderController::class, 'store']);
Route::post('/showorderdetail/{id}', [ResturantorderController::class, 'show']);
