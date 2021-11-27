<?php

use App\Http\Controllers\PokemonController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('register', [UserController::class,  'register']);
Route::post('login', [UserController::class, 'authenticate']);

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get("/get-pokemon", [PokemonController::class, "index"]);
    Route::post("/create-pokemon", [PokemonController::class, "store"]);
    Route::get("/details-pokemon/{id}", [PokemonController::class, "get"]);
    Route::put("/update-pokemon/{id}", [PokemonController::class, "update"]);
    Route::delete("/delete-pokemon/{id}", [PokemonController::class, "destroy"]);

    Route::post('user', [UserController::class, 'getAuthenticatedUser']);
    Route::post('logout', [UserController::class, 'logout']);
});

Route::post("test", [PokemonController::class, "test"]);
