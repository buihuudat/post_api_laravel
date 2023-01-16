<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    try {
      $category = Category::orderBy('id', 'desc')->get();
      if ($category) {
        return response()->json([
          'success' => true,
          'category' => $category
        ]);
      }
    } catch (\Exception $err) {
      return response()->json([
        'sucess' => false,
        'error' => $err->getMessage()
      ]);
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
        'category_name' => ['required', 'string'],
      ]);
      if ($validation->fails()) {
        return response()->json([
          'success' => false,
          'error' => $validation->errors()->all()
        ]);
      }

      $category = Category::create([
        'category_name' => $request->category_name
      ]);

      if (!$category) {
        return response()->json([
          'success' => false,
          'message' => 'some thing bugs'
        ]);
      }

      return response()->json([
        'success' => true,
        'message' => 'Category created successfully',
        'category' => $category
      ]);
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'message' => $err->getMessage()
      ]);
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
    $category = Category::find($id);
    if (!$category) {
      return response()->json([
        'success' => false,
        'message' => 'Category not found'
      ]);
    }

    return response()->json([
      'success' => true,
      'category' => $category
    ]);
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
    $category = Category::find($id);
    if (!$category) {
      return response()->json([
        'success' => false,
        'message' => 'Category not found'
      ]);
    }

    $validation = Validator::make($request->all(), [
      'category_name' => ['required', 'string']
    ]);

    if ($validation->fails()) {
      return response()->json([
        'success' => false,
        'message' => $validation->errors()->all()
      ]);
    }

    $category->update([
      'category_name' => $request->category_name
    ]);

    return response()->json([
      'success' => true,
      'message' => 'Update successfully',
      'category' => $category
    ]);
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
      $category = Category::find($id);

      if (!$category) {
        return response()->json([
          'success' => false,
          'message' => 'category not found'
        ]);
      }

      $category->delete();
      return response()->json([
        'success' => true,
        'message' => 'deleted successfully'
      ]);
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'mesagge' => $err->getMessage()
      ]);
    }
  }

  public function search($search)
  {
    try {
      $category = Category::where('category_name', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->get();
      if ($category) {
        return response()->json([
          'success' => true,
          'category' => $category
        ]);
      }
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'message' => $err->getMessage()
      ]);
    }
  }
}
