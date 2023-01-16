<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
  public function index()
  {
    try {
      $contacts = Contact::orderBy('id', 'desc')->get();
      return response()->json([
        'success' => true,
        'contacts' => $contacts
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
      $contact = Contact::findOrFail($id);
      if ($contact) {
        $contact->delete();

        return response()->json([
          'success' => true,
          'message' => 'Contact deleted successfully'
        ]);
      }
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'error' => $err->getMessage()
      ]);
    }
  }
}
