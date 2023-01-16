<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
  public function comments()
  {
    try {
      $comments = Comment::orderBy('id', 'desc')->get();
      return response()->json([
        'success' => true,
        'comments' => $comments
      ], 200);
    } catch (\Exception $err) {
      return response()->json([
        'success' => true,
        'error' => $err->getMessage()
      ], 404);
    }
  }

  public function store(Request $request, $id)
  {
    try {
      $post = Post::findOrFail($id);
      if ($post) {
        $validation = Validator::make($request->all(), [
          'name' => ['required', 'string'],
          'email' => ['required', 'email'],
          'comment' => ['required']
        ]);

        if ($validation->fails()) {
          return response()->json([
            'success' => false,
            'message' => 'validation',
            'error' => $validation->errors()->all()
          ], 500);
        }

        $comment = Comment::create([
          'post_id' => $id,
          'name' => $request->name,
          'email' => $request->email,
          'comment' => $request->comment,
        ]);

        return response()->json([
          'success' => true,
          'message' => 'comment successfully',
          'comment' => $comment
        ], 201);
      }
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'error' => $err->getMessage()
      ]);
    }
  }
}
