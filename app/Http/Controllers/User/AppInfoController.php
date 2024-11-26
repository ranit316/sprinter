<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AppInfo;
use App\Models\Cms_pages;
use Illuminate\Http\Request;

class AppInfoController extends Controller
{
    public function appinfo()
    {
        $baseURL = request()->root();
        $data = AppInfo::get()->first();

        if (!$data) {
            // Handle the case where no data is found
            return response()->json(['error' => 'No data found'], 404);
        }

        $data->logo = $data->logo ? $baseURL . '/' . $data->logo : $baseURL . '/' . asset('image/applogo/SprinterLogo.png');
        $data->dark_logo = $data->dark_logo ? $baseURL . '/' . $data->dark_logo : $baseURL . '/' . asset('image/applogo/SprinterLogo.png');
        $data->fav_icon = $data->fav_icon ? $baseURL . '/' . $data->fav_icon : $baseURL . '/' . asset('image/applogo/SprinterLogo.png');

        $whats_app_numbers = [];
        for ($i = 1; $i <= 5; $i++) {
            $whatsappField = "whats_app_$i";
            if ($data->$whatsappField !== '') {
                $whats_app_numbers[] = $data->$whatsappField;
            }

            if (isset($data->$whatsappField) || $data->$whatsappField == null) {
                unset($data->$whatsappField);
            }
        }
        $data->whats_app = $whats_app_numbers;


        $datas = array(
            'PlatformCTA' => $data->whats_app_6,  
        );
        unset($data->whats_app_6);
        $data->PlatformCTA = $datas;

        $pages = Cms_pages::get();

        // for ($i = 1; $i <= 6; $i++) {
        //     $whatsappField = "whats_app_$i";
            
        // }
        $data['cms'] = $pages;
        
        

        return response()->json(responseData($data, "all data retrieve successfully"));
    }
}
