<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'email' => ['required', 'email'],
      'password' => ['required', 'min:6']
    ]);

    if ($validation->fails()) {
      return response()->json([
        'success' => false,
        'message' => $validation->errors()->all()
      ]);
    }

    if (!Auth::attempt($request->all())) {
      return response()->json([
        'success' => false,
        'message' => 'Invalid email or password'
      ]);
    }

    return response()->json([
      'success' => true,
      'user' => auth()->user(),
      'token' => auth()->user()->createToken('secret')->plainTextToken
    ]);
  }

  public function register(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'name' => ['required', 'string'],
      'email' => ['email', 'required'],
      'password' => ['required', 'min:6']
    ]);


    if ($validation->fails()) {
      return response()->json([
        'success' => false,
        'message' => $validation->errors()->all()
      ]);
    }

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => bcrypt($request->password)
    ]);

    return response()->json([
      'user' => $user,
      'token' => $user->createToken('secret')->plainTextToken
    ], 200);
  }

  public function user($id)
  {
    $user = User::find($id);

    if (!$user) {
      return response()->json([
        'success' => false,
        'message' => 'User not found'
      ]);
    }

    return response()->json([
      'success' => true,
      'user' => $user,
      'token' => $user->createToken('secret')->plainTextToken
    ]);
  }

  public function logout(Request $request)
  {
    $id = $request->user()->id;
    auth()->user()->tokens()->where('tokenable_id', $id)->delete();
  }
}
