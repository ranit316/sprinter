<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class AppSettingController extends Controller
{
    public function appsetting(Request $request)
    {
        $id = auth()->user()->id;

        $data = AppSetting::create([
            'cus_id' => $id,
            'device_id' => $request->device_id,
        ]);

        if($data)
        {
            return response()->json(responseData(null, "Device id save"));
        }else{
            return response()->json(responseData(null, "something went wrong",false));
        }
    }
}
