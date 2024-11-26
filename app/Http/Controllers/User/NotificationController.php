<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Offer;

class NotificationController extends Controller
{
    public function offer()
    {
        $baseURL = request()->root();
        $data = Offer::where('status', 'Active')->where('is_feature','yes')->first();
        if (!$data) {
            return response()->json(responseData(null, "No active featured offer found", false));
        }
    
        $data->photo = $baseURL . '/' . $data->photo;
        $data->description = strip_tags($data->description);

        return response()->json(responseData($data, "Offer retrieved successfully"));
    }

    public function notification()
    {
        $id = auth()->user()->id;
        // $data = Notification::where(function ($query) use ($id){
        //     $query->where('user_id',$id)->orWhereNull('user_id');
        // })->get();
        $data = Notification::where('user_id',$id)->get();
        if($data)
        {
            return response()->json(responseData($data,"all data retrive successfully"));
        }else{
            return response()->json(responseData(null,"something went wrong",false));
        }

        // $firebaseToken = AppSetting::whereNotNull('device_token')->pluck('device_token')->all();
            
        // $SERVER_API_KEY = env('FCM_SERVER_KEY');
    
        // $data = [
        //     "registration_ids" => $firebaseToken,
        //     "notification" => [
        //         "title" => $request->title,
        //         "body" => $request->body,  
        //     ]
        // ];
        // $dataString = json_encode($data);
      
        // $headers = [
        //     'Authorization: key=' . $SERVER_API_KEY,
        //     'Content-Type: application/json',
        // ];
      
        // $ch = curl_init();
        
        // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                 
        // $response = curl_exec($ch);
    
        // return back()->with('success', 'Notification send successfully.');
    }


    public function sendpushnotification(Request $request)
    {
        $firebaseToken = AppSetting::whereNotNull('device_id')->pluck('device_id')->all();
            
        $SERVER_API_KEY = env('FCM_SERVER_KEY');
    
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,  
            ]
        ];
        $dataString = json_encode($data);
      
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
      
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                 
        $response = curl_exec($ch);
    
        return back()->with('success', 'Notification send successfully.');
    }

    public function deleteNotification(Request $request)
    {
        $id = auth()->user()->id;
        $notification_id = $request->notification_id;
        if($notification_id != null)
        {
            $data = Notification::where('id',$notification_id)->delete();
        }else{
            $data = Notification::where('user_id',$id)->delete();
        }
        
        if($data)
        {
            return response()->json(responseData(null,'delete successlully'));
        }else{
            return response()->json(responseData(null,'Failed to delete notification',false));
        }
    }

}
