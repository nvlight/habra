<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ImagableController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaggableController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('img_files', [ImageController::class, 'img_files']);
Route::post('img_exists', [ImageController::class, 'img_exists']);
Route::post('img_create', [ImageController::class, 'img_create']);

Route::apiResources([
    'comment' => CommentController::class,
    'post' => PostController::class,
    'company' => CompanyController::class,
    'tag' => TagController::class,
    'image' => ImageController::class,
    'taggable' => TaggableController::class,
    'imagable' => ImagableController::class,
]);

Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum', 'as' => 'user.'], function (){
    Route::post('login', [UserController::class, 'login'])->name('login');
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    Route::post('chich', [UserController::class, 'chich'])->name('chich');
});
