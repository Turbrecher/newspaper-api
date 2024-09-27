<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Models\Comment;
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


//AUTH
Route::post('/login', [UserController::class, "login"])->name("login");
Route::post('/register', [UserController::class, "register"])->name("register");
Route::post('/logout', [UserController::class, "logout"])->name("logout")->middleware("auth:sanctum");
Route::post('/profile', [UserController::class, "profile"])->name("profile")->middleware("auth:sanctum");

//USERS
Route::get('/users', [UserController::class, "getUsers"])->name("userList")->middleware("auth:sanctum");
Route::get('/users/{id}', [UserController::class, "getUser"])->name("userDetails")->middleware("auth:sanctum");
Route::put('/users/{id}', [UserController::class, "editUser"])->name("userEdit")->middleware("auth:sanctum");


//ARTICLES
Route::get('/articles', [ArticleController::class, "getArticles"])->name("articleList");
Route::post('/articles', [ArticleController::class, "createArticle"])->name("articleCreate")->middleware("auth:sanctum");
Route::get('/articles/{id}', [ArticleController::class, "getArticle"])->name("articleDetails");
Route::put('/articles/{id}', [ArticleController::class, "editArticle"])->name("articleEdit")->middleware("auth:sanctum");



//COMMENTS
Route::get('/comments', [CommentController::class, "getComments"])->name("commentList");
Route::post('/comments', [CommentController::class, "createComment"])->name("commentCreate")->middleware("auth:sanctum");
Route::get('/comments/{id}', [CommentController::class, "getComment"])->name("commentDetails");
Route::put('/comments/{id}', [CommentController::class, "editComment"])->name("commentEdit")->middleware("auth:sanctum");
