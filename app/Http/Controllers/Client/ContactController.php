<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
  public function store(Request $request)
  {
    try {
      $validation = Validator::make($request->all(), [
        'name' => ['required', 'string', 'min:6'],
        'email' => ['required', 'email', 'string'],
        'subject' => ['required', 'string'],
        'message' => ['required']
      ]);
      if ($validation->fails()) {
        return response()->json([
          'success' => false,
          'message' => 'Validation',
          'error' => $validation->errors()->all()
        ], 500);
      }

      $contact = Contact::create([
        'name' => $request->name,
        'email' => $request->email,
        'subject' => $request->subject,
        'message' => $request->message,
      ]);

      return response()->json([
        'success' => true,
        'message' => 'contact created successfully',
        'contact' => $contact
      ], 201);
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'error' => $err->getMessage()
      ], 404);
    }
  }
}
