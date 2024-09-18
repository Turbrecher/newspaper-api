<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Models\User;
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

//USERS
Route::get('/users', [UserController::class, "getUsers"])->name("userList");
Route::post('/users', [UserController::class, "createUser"])->name("userCreate");
//Route::middleware('auth:sanctum')->post('/users', [UserController::class, "createUser"])->name("userCreate");
Route::get('/users/{id}', [UserController::class, "getUser"])->name("userDetails");
//Route::middleware('auth:sanctum')->put('/users/{id}', [UserController::class, "editUser"])->name("userEdit");
Route::put('/users/{id}', [UserController::class, "editUser"])->name("userEdit");


//ARTICLES
Route::get('/articles', [ArticleController::class, "getArticles"])->name("articleList");
Route::post('/articles', [ArticleController::class, "createArticle"])->name("articleCreate");
//Route::middleware('auth:sanctum')->post('/users', [UserController::class, "createUser"])->name("userCreate");
Route::get('/articles/{id}', [ArticleController::class, "getArticle"])->name("articleDetails");
//Route::middleware('auth:sanctum')->put('/users/{id}', [UserController::class, "editUser"])->name("userEdit");
Route::put('/articles/{id}', [ArticleController::class, "editArticle"])->name("articleEdit");


//LOGIN
Route::any("/login", function () {
    return response()->json(
        ["error" => "You have to log in before doing this request"],
        401
    );
})->name("login");
