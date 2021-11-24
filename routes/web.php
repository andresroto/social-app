<?php

use App\Http\Controllers\AcceptFriendshipController;
use App\Http\Controllers\CommentLikesController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReadNotificationController;
use App\Http\Controllers\StatusCommentController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StatusLikesController;
use App\Http\Controllers\UserStatusController;
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

Route::view('/', 'welcome'); 

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


// Statuses
Route::get('statuses', [StatusController::class, 'index'])->name('statuses.index');
Route::get('statuses/{status}', [StatusController::class, 'show'])->name('statuses.show');
Route::post('statuses', [StatusController::class, 'store'])->name('statuses.store')->middleware(['auth']);

// Statuses Likes
Route::post('statuses/{status}/likes', [StatusLikesController::class, 'store'])->name('statuses.likes.store')->middleware(['auth']);
Route::delete('statuses/{status}/likes', [StatusLikesController::class, 'destroy'])->name('statuses.likes.destroy')->middleware(['auth']);

// Friends 
Route::get('friends', [FriendController::class, 'index'])->name('friends.index')->middleware(['auth']);

// Statuses comments
Route::post('statuses/{status}/comments', [StatusCommentController::class, 'store'])->name('statuses.comments.store')->middleware(['auth']);

// Comments likes
Route::post('comments/{comment}/likes', [CommentLikesController::class, 'store'])->name('comments.likes.store')->middleware(['auth']);
Route::delete('comments/{comment}/likes', [CommentLikesController::class, 'destroy'])->name('comments.likes.destroy')->middleware(['auth']);

// Users
Route::get('users/{user}/statuses', [UserStatusController::class, 'index'])->name('users.statuses.index'); 
Route::get('@{user}', [UserController::class, 'show'])->name('users.show'); 

// Friendships 
Route::post('friendships/{recipient}', [FriendshipController::class, 'store'])->name('friendships.store')->middleware(['auth']);
Route::delete('friendships/{user}', [FriendshipController::class, 'destroy'])->name('friendships.destroy')->middleware(['auth']);

// Request friendships
Route::get('friends/requests', [AcceptFriendshipController::class, 'index'])->name('accept-friendships.index')->middleware(['auth']);;
Route::post('accept-friendships/{sender}', [AcceptFriendshipController::class, 'store'])->name('accept-friendships.store')->middleware(['auth']);
Route::delete('accept-friendships/{sender}', [AcceptFriendshipController::class, 'destroy'])->name('accept-friendships.destroy')->middleware(['auth']);

// Notifications
Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index')->middleware(['auth']);

// Read notifications
Route::post('read-notifications/{notification}', [ReadNotificationController::class, 'store'])->name('read-notifications.store')->middleware(['auth']);
Route::delete('read-notifications/{notification}', [ReadNotificationController::class, 'destroy'])->name('read-notifications.destroy')->middleware(['auth']);


require __DIR__.'/auth.php';
