<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostReactsController;
use App\Http\Controllers\CommentReactsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\EventUsersController;
use App\Http\Controllers\FollowsController;
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
    Route::post('/me/events', [EventUsersController::class, 'getAll']);
    Route::post('/me/events/{events_id}', [EventUsersController::class, 'getSingle']);

    // POST
    Route::post('/posts/create', [PostsController::class, 'create']);
    Route::post('/posts/{posts_id}', [PostsController::class, 'getSinglePost']);
    Route::post('/posts', [PostsController::class, 'getAllPost']);
    Route::post('/posts/{posts_id}/update', [PostsController::class, 'update']);
    Route::post('/posts/{posts_id}/destroy', [PostsController::class, 'destroy']);
    Route::post('/posts/{posts_id}/share', [PostsController::class, 'share']);

    //POST REACT
    Route::post('/posts/{posts_id}/reacts/create', [PostReactsController::class, 'create']);
    Route::post('/posts/{posts_id}/reacts/{post_react_id}/destroy', [PostReactsController::class, 'destroy']);

    //COMMENT
    Route::post('/comments/{posts_id}/create', [CommentsController::class, 'create']);
    Route::post('/comments/{comments_id}', [CommentsController::class, 'getSingleComment']);
    Route::post('/comments/{comments_id}/update', [CommentsController::class, 'update']);
    Route::post('/comments/{comments_id}/destroy', [CommentsController::class, 'destroy']);
    Route::post('/comments/{posts_id}/reply/{comments_id}', [CommentsController::class, 'reply']);
    
    //COMMENT REACT
    Route::post('/comments/{comment_id}/reacts/create', [CommentReactsController::class, 'create']);
    Route::post('/comments/{comment_id}/reacts/{comment_react_id}/destroy', [CommentReactsController::class, 'destroy']);

    //SEARCHES 
    Route::post('/search/{slug}', [SearchController::class, 'get']);

    //PROFILE (OTHER USERS)
    Route::post('/profile/{id}', [UserController::class, 'get']);

    //EVENTS
    Route::post('/events/create', [EventsController::class, 'create']);
    Route::post('/events', [EventsController::class, 'getAll']);
    Route::post('/events/{event_id}', [EventsController::class, 'get']);
    Route::post('/events/{events_id}/update', [EventsController::class, 'update']);
    Route::post('/events/{events_id}/destroy', [EventsController::class, 'destroy']);

    //EVENT USERS
    Route::post('/events/{events_id}/join', [EventUsersController::class, 'create']);

    //Add Friend
    Route::post('/u/{user_id}/follow', [FollowsController::class, 'create']);
    Route::post('/u/{user_id}/unfollow', [FollowsController::class, 'delete']);
});