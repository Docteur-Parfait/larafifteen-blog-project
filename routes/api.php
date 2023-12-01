<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CategorieController;

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

// Routes categorie
Route::get("categories", [CategorieController::class, "index"]);
Route::get("categories/{id}", [CategorieController::class, "show"]);
Route::put("categories/{id}", [CategorieController::class, "update"]);
Route::post("categories", [CategorieController::class, "store"]);
Route::delete("categories/{id}", [CategorieController::class, "destroy"]);


// Articles
Route::get("articles", [ArticleController::class, "index"]);
Route::get("articles/{id}", [ArticleController::class, "show"]);
Route::put("articles/{id}", [ArticleController::class, "update"]);
Route::post("articles", [ArticleController::class, "store"]);
Route::delete("articles/{id}", [ArticleController::class, "destroy"]);
