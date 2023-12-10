<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CMSController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\JournalistController;

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
//novinar
Route::get('/cms-journalist',[JournalistController::class,'showCMS'])->middleware('journalist');
Route::get('/cms-journalist/drafts',[JournalistController::class,'showDrafts'])->middleware('journalist');
Route::get('/cms-journalist/create-post',[JournalistController::class,'showCreatePost'])->middleware('journalist');
Route::post('/cms-journalist/create-post',[NewsController::class, 'createPost'])->middleware('journalist');
Route::get('/cms-journalist/delete/{article}',[JournalistController::class,'deletePost'])->middleware('journalist');
Route::get('/cms-journalist/edit/{article}',[JournalistController::class,'showEditPost'])->middleware('journalist');
Route::post('/cms-journalist/edit/{article}',[JournalistController::class,'editPost'])->middleware('journalist');

//urednik

//cms
Route::get('/cms',[CMSController::class,'showCMSScreen'])->middleware('cms');
Route::get('/cms/create-post',[CMSController::class, 'showCreatePostScreen'])->middleware('cms');
Route::post('/cms/create-post',[NewsController::class, 'createPost'])->middleware('cms');
Route::get('/cms/users',[CMSController::class,'showUsers'])->middleware('cms');
Route::get('/cms/edit-user/{user}',[CMSController::class,'showEditUser'])->middleware('cms');
Route::post('/cms/update-user/{user}',[CMSController::class,'editUser'])->middleware('cms');
Route::get('/cms/delete-user/{user}',[CMSController::class,'deleteUser'])->middleware('cms');
Route::get('/cms/journalist',[CMSController::class,'showNovinar'])->middleware('cms');
Route::get('/cms/categories',[CMSController::class,'showCategories'])->middleware('cms');
Route::post('/cms/add-category',[CMSController::class,'addCategory'])->middleware('cms');
Route::post('/cms/edit-category/{category}',[CMSController::class,'editCategory']);
Route::get('/cms/delete-category/{category}',[CMSController::class,'deleteCategory'])->middleware('cms');
Route::get('/cms/remove-category-from-journalist',[CMSController::class,'removeCategoryFromJournalist'])->middleware('cms');
Route::get('/cms/update-journalist/{user}',[CMSController::class,'showUpdateEJ'])->middleware('cms');
Route::post('/cms/update-journalist/{user}',[CMSController::class,'updateCategoriesEJ'])->middleware('cms');
Route::get('/cms/editors',[CMSController::class,'showEditors'])->middleware('cms');
Route::get('/cms/edit-editor/{user}',[CMSController::class,'showUpdateEJ'])->middleware('cms');
Route::post('/cms/edit-editor/{user}',[CMSController::class,'updateCategoriesEJ'])->middleware('cms');



