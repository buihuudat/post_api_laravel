<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
  public function index()
  {
    try {
      $setting = Setting::findOrFail(1);
      return response()->json([
        'success' => true,
        'settings' => $setting
      ]);
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'message' => $err->getMessage()
      ]);
    }
  }

  public function update(Request $request, $id)
  {
    try {
      $setting = Setting::findOrFail($id);
      $setting->update([
        'header_logo' => $request->header_logo,
        'footer_logo' => $request->footer_logo,
        'footer_desc' => $request->footer_desc,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
        'facebook' => $request->facebook,
        'instagram' => $request->instagram,
        'youtube' => $request->youtube,
        'about_title' => $request->about_title,
        'about_desc' => $request->about_desc
      ]);
      return response()->json([
        'success' => true,
        'message' => 'setting updated successfully',
        'setting' => $setting
      ]);
    } catch (\Exception $err) {
      return response()->json([
        'success' => false,
        'error' => $err->getMessage()
      ]);
    }
  }
}
