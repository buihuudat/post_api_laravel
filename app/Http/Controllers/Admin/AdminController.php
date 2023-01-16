<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
  public function admin(Request $request)
  {
    return response()->json([
      'users' => $request->user()
    ]);
  }
}
