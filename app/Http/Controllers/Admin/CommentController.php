<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
  public function index()
  {
    try {
      $comments = Comment::orderBy('id', 'desc')->get();

      return response()->json([
        'success' => true,
        'comments' => $comments
      ]);
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'error' => $err->getMessage()
      ]);
    }
  }

  public function delete($id)
  {
    try {
      $comment = Comment::findOrFail($id);
      if ($comment) {
        $comment->delete();
        return response()->json([
          'success' => true,
          'message' => 'Comment deleted successfully'
        ]);
      }
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'error' => $err->getMessage()
      ]);
    }
  }

  public function store(Request $request)
  {
  }
}
