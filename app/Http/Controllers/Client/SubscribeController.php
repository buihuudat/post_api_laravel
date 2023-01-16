<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDO;

class SubscribeController extends Controller
{
  public function store(Request $request)
  {
    try {
      $validation = Validator::make($request->all(), [
        'email' => ['email', 'required']
      ]);

      Subscribe::create([
        'email' => $request->email
      ]);

      if ($validation->fails()) {
        return response()->json([
          'success' => false,
          'message' => 'validation',
          'error' => $validation->errors()->all()
        ], 500);
      }

      return response()->json([
        'success' => true,
        'message' => 'subscribe successfully'
      ], 201);
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'message' => '',
        'error' => $err->getMessage()
      ], 404);
    }
  }
}
