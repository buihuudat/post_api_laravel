<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
  public function posts()
  {
    try {
      $posts = Post::orderBy('id', 'desc')->get();
      return response()->json([
        'success' => true,
        'posts' => $posts
      ], 200);
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'error' => $err->getMessage()
      ], 404);
    }
  }

  public function post($id)
  {
    try {
      $post = Post::findOrFail($id);
      if ($post) {
        return response()->json([
          'success' => true,
          'post' => $post
        ], 200);
      }
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'mesage' => 'Post not found',
        'error' => $err->getMessage()
      ], 404);
    }
  }

  public function viewPosts()
  {
    try {
      $posts = Post::with('categories')->where('views', '>', 0)->orderBy('id', 'desc')->get();

      return response()->json([
        'success' => true,
        'posts' => $posts
      ], 200);
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'error' => $err->getMessage()
      ], 404);
    }
  }

  public function categoryPost($id)
  {
    try {
      $posts = Post::with('categories')->where('id', $id)->orderBy('id', 'desc')->get();

      return response()->json([
        'success' => true,
        'posts' => $posts
      ], 200);
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'message' => 'Category not fond in post',
        'error' => $err->getMessage()
      ], 404);
    }
  }

  public function searchPost($search)
  {
    try {
      $posts = Post::where('title', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->get();

      return response()->json([
        'success' => true,
        'posts' => $posts
      ], 200);
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'error' => $err->getMessage()
      ]);
    }
  }
}
