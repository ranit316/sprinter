<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\SupportMail;
use App\Models\AppInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Illuminate\Support\Facades\Log;

class SupportController extends Controller
{
    public function support(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_name' => 'required',
            'email' => 'required|email',
            'client_id' => 'required',
            'Subject' => 'required',
            'message' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024'

        ]);

        $id = auth()->user()->id;
        $cus = User::where('id',$id)->first();
        $cc_mail = AppInfo::first();

        if ($validator->fails()) {
            $message = $validator->errors();
            return response()->json(responseData(null, $message, false));
        }
        $ref_no = date("Y-m") . '-spo-' . substr(md5(uniqid(rand(), true)), -20, 4); 
        $date = Carbon::now()->format('y-m-d H:i');
        $maildata = [
            'name' => $cus->name,
            'site_name' => $request->site_name,
            'client_id' => $request->client_id,
            'Subject' => $request->Subject,
            'message' => $request->message,
            'image' => $request->image ?? '',
            'ref_no' => $ref_no,
            'date' => $date
        ];
        try {
            Mail::to($request->email)->cc($cc_mail->email)->send(new SupportMail($maildata));
        } catch (Throwable $t) {
            Log::error('mail sending fail: ' . $t->getmessage());
        }
        $data = [
            'data' => $request->all(),
            'ref_no' => $ref_no,
            'date' => $date,
        ];

        return response()->json(responseData($data,"information received"));

        
    }
}
