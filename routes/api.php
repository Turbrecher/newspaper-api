<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/users', function () {
    return response()->json(
        [
            [
                "user" => "user1"
            ],
            [
                "user" => "user2"
            ],
        ],
        404
    );
})->name("users");


Route::get('/user/{id}', function (int $id) {
    return response()->json(
        [
            "id" => $id
        ],
        404
    );
})->name("user");
