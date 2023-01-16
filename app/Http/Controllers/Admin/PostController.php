<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use PDO;

class PostController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    try {
      $post = Post::orderBy('id', 'desc')->with('categories')->get();
      if (!$post) {
        return response()->json([
          'success' => false,
          'message' => 'Post not found'
        ], 404);
      }

      return response()->json([
        'success' => true,
        'posts' => $post
      ], 200);
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'message' => $err->getMessage()
      ], 404);
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    try {
      $validation = Validator::make($request->all(), [
        'title' => ['required', 'string', 'min:10', 'max: 100', 'unique:posts'],
        'description' => ['required', 'string', 'min:10', 'max: 1000'],
        'cat_id' => ['required'],
        'image' => ['required']
      ]);

      if ($validation->fails()) {
        return response()->json([
          'success' => false,
          'error' => $validation->errors()->all()
        ], 500);
      }

      $image = "";
      if ($request->file('image')) {
        $image = $request->file('image')->store('posts', 'public');
      } else {
        $image = "";
      }

      $post = Post::create([
        'title' => $request->title,
        'description' => $request->description,
        'cat_id' => $request->cat_id,
        'image' => $image,
        'views' => 0
      ], 201);

      return response()->json([
        'success' => true,
        'message' => 'Post created successfully',
        'post' => $post
      ]);
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'message' => $err->getMessage()
      ], 404);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    try {
      $post = Post::where('title', 'LIKE', '%' . $id . '%')->orderBy('id', 'desc')->with('categories')->get();
      if ($post) {
        return response()->json([
          'success' => true,
          'post' => $post
        ]);
      }
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'error' => $err->getMessage()
      ]);
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    try {
      $post = Post::findOrFail($id);
      $validation = Validator::make($request->all(), [
        'title' => ['required', 'string', 'min:10', 'max: 100', 'unique:posts'],
        'description' => ['required', 'string', 'min:10', 'max: 1000'],
        'cat_id' => ['required'],
        'image' => ['required']
      ]);
      if ($validation->fails()) {
        return response()->json([
          'success' => false,
          'error' => $validation->errors()->all()
        ], 500);
      }

      $image = "";
      $destination = public_path('storage\\' . $post->image);
      if ($request->file('new_image')) {
        if (File::exists($destination)) {
          File::delete($destination);
        }

        $image = $request->file('new_image')->store('posts', 'public');
      }

      $post->udpate([
        'title' => $request->title,
        'description' => $request->description,
        'cat_id' => $request->cat_id,
        'image' => $image
      ]);

      return response()->json([
        'success' => true,
        'message' => 'Post updated successfully',
        'post' => $post
      ], 200);
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'message' => $err->getMessage()
      ], 404);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    try {
      $post = Post::findOrFail($id);
      $post->delete();

      return response()->json([
        'success' => true,
        'message' => 'Post Deleted successfully'
      ], 200);
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'error' => $err->getMessage()
      ], 404);
    }
  }

  public function search($search)
  {
  }
}
