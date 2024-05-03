<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// эта штука работает, но этот вариант не интересен
//Route::get('/{any}', function () {
//    return response()->json(['error' => 'Ресурс не найден'], 404);
//})->where('any', '.*');


//Route::apiResource('comment', CommentController::class);
//Route::apiResource('post', PostController::class);
//Route::apiResource('company', CompanyController::class);
Route::apiResources([
    'comment' => CommentController::class,
    'post' => PostController::class,
    'company' => CompanyController::class,
]);


