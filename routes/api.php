<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubscribeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\CommentController as ClientCommentController;
use App\Http\Controllers\Client\ContactController as ClientContactController;
use App\Http\Controllers\Client\PostController as ClientPostController;
use App\Http\Controllers\Client\SubscribeController as ClientSubscribeController;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
  Route::get('admin', [AdminController::class, 'admin']);

  Route::prefix('categories')->group(
    function () {
      Route::get('{search}', [CategoryController::class, 'search']);
      Route::resource('/', CategoryController::class);
    }
  );

  Route::resource('posts', PostController::class);

  Route::controller(SettingController::class)->group(
    function () {
      Route::get('settings', 'index');
      Route::put('settings/{id}', 'update');
    }
  );

  Route::controller(ContactController::class)->group(
    function () {
      Route::get('contacts', 'index');
      Route::delete('contacts/{id}', 'delete');
    }
  );

  Route::controller(SubscribeController::class)->group(
    function () {
      Route::get('subscribe', 'index');
      Route::delete('subscribe/{id}', 'delete');
    }
  );

  Route::controller(CommentController::class)->group(
    function () {
      Route::get('comments', 'index');
      Route::delete('comments/{id}', 'delete');
    }
  );
});

Route::controller(AuthController::class)->group(function () {
  Route::post('register', 'register');
  Route::post('login', 'login')->name('login');
  Route::get('user/{id}', 'user');
  Route::get('logout', 'logout');
});

Route::prefix('client')->group(function () {
  Route::controller(ClientPostController::class)->group(
    function () {
      Route::get('posts', 'posts');
      Route::get('post/{id}', 'post');
      Route::get('viewd-posts', 'viewPosts');
      Route::get('category-post/{id}', 'categoryPost');
      Route::get('search-post/{search}', 'searchPost');
    }
  );
  Route::post('contact', [ClientContactController::class, 'store']);
  Route::post('subscribe', [ClientSubscribeController::class, 'store']);
  Route::get('comments', [ClientCommentController::class, 'comments']);
  Route::post('comments/{id}', [ClientCommentController::class, 'store']);
});
