<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Mockery\Matcher\Subset;

class SubscribeController extends Controller
{
  public function index()
  {
    try {
      $subscribes = Subscribe::orderBy('id', 'desc')->get();

      return response()->json([
        'success' => true,
        'subscribes' => $subscribes
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
      $subscribe = Subscribe::findOfFail($id);
      if ($subscribe) {
        $subscribe->delete();
        return response()->json([
          'success' => true,
          'message' => 'Subscribe deleted successfully'
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
