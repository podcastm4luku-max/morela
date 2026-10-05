<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;

class AppSettingController extends Controller
{
    public function index()
    {
        return response()->json(AppSetting::pluck('value', 'key'));
    }

    public function update(Request $request)
    {
        $settings = $request->all();
        foreach ($settings as $key => $value) {
            AppSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        return response()->json([
            'message' => 'Settings updated successfully',
            'data' => AppSetting::pluck('value', 'key')
        ]);
    }
}
