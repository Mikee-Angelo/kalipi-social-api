<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/register', [ApiAuthController::class, 'register']);

Route::group([
    'middleware' => 'api'

], function ($router){
    Route::post('logout', [ApiAuthController::class, 'logout']);
    Route::post('refresh', [ApiAuthController::class, 'refresh']);
    Route::post('me', [ApiAuthController::class, 'me']);

    // POST
    Route::post('/posts/create', [PostsController::class, 'create']);
    Route::post('/posts/{posts_id}', [PostsController::class, 'getSinglePost']);
    Route::post('/posts/{posts_id}/update', [PostsController::class, 'update']);
    Route::post('/posts/{posts_id}/destroy', [PostsController::class, 'destroy']);

    //COMMENT
    Route::post('/comments/{posts_id}/create', [CommentsController::class, 'create']);
    Route::post('/comments/{comments_id}', [CommentsController::class, 'getSingleComment']);
    Route::post('/comments/{comments_id}/update', [CommentsController::class, 'updates']);
    Route::post('/comments/{comments_id}/destroy', [CommentsController::class, 'destroy']);
    

});