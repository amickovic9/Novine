<?php

use App\Http\Controllers\CMSController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/',[UserController::class,'showHomePage']);
Route::get('/login',[UserController::class,'showLoginPage']);
Route::post('/login',[UserController::class,'loginUser']);
Route::post('/register',[UserController::class,'registerUser']);
Route::get('/logout',[UserController::class,'logoutUser']);
Route::get('/article/{article}',[NewsController::class,'showArticle']);
Route::post('/add-comment',[CommentController::class,'addComment']);


//cms
Route::get('/cms',[CMSController::class,'showCMSScreen']);
Route::get('/cms/create-post',[CMSController::class, 'showCreatePostScreen']);
Route::post('/cms/create-post',[NewsController::class, 'createPost']);
