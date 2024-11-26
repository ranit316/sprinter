<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\ForgotpasswordMail;
use App\Mail\ChangepasswordMail;
use App\Mail\RegistrationMail;
use App\Mail\LoginvarificationMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Otp;
use App\Models\RefferalCode;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Carbon\Carbon;
use Throwable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Notification;
use Illuminate\Support\Carbon as SupportCarbon;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            //'last_name' => 'required',
            //'phone_number' => 'required',
            //'address' => 'required',
            'password' => 'required',
            'status' => 'required',
            'email' => 'required|unique:users,email',
            //'ref_code' => 'sometimes|exists:refferal_codes,ref_code',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors();
            return response()->json(responseData(null, $message, false));
        }

        // $name = $request->first_name;
        // $nameparts = explode(" ", $name);


        $ref_id = RefferalCode::where('ref_code', $request->ref_code)->first();
        if (isset($request->ref_code) && $ref_id == null) {
            return response()->json(responseData(null, "please provide valid referral code", false));
        }


        DB::beginTransaction();

        try {
            $name = $request->first_name;
            $user = User::create([
                'name' => $request->first_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'type' => 'Customer',
            ]);

            $customer = Customer::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                //'last_name' => isset($nameparts[1]) ? implode(" ", array_slice($nameparts, 1)) : '',
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'status' => $request->status,
                'user_id' => $user->id,
                'ref_id' => $ref_id->cus_id ?? null,

            ]);
            $a = str_replace(' ', '', $name);
            $reffel_code = strtolower(substr($a, 0, 4) . rand(1000, 9999));

            $name_e = $request->first_name;
            $pass = $request->password;
            $email = $request->email;

            $this->regmail($name_e, $pass, $email);
            RefferalCode::create([
                'cus_id' => $customer->id,
                'ref_code' => $reffel_code,
            ]);

            DB::commit();
            $data = User::where('id', $user->id)->first();
            $data['reffel_code'] = $reffel_code;


            Notification::create([
                'module' => 'Customer',
                'message' => 'Congratulations! Your Sprinters Online account has been successfully created.',
                'is_openabl' => 'yes',
                'action' => 'add',
                'table' => 'customer',
                'table_id' => $customer->id,
                'created_by' => $user->id,
                'user_id' => $user->id,
            ]);

            return response()->json(responseData($data, "Customer Added Successfully"));
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(responseData(null, $e->getMessage(), false));
        }
    }

    public function checkemail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email',
            //'ref_code' => 'sometimes|exists:refferal_codes,ref_code',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors();
            return response()->json(responseData(null, $message, false));
        }
        $otp = rand(1000, 9999);
        $email = $request->email;
        $this->validationmail($email, $otp);

        $data['otp'] = $otp;
        $data['email'] = $email;
        return response()->json(responseData($data, "otp send to email id"));
    }



    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials) && auth()->user()->type == 'Customer') {
            $user = Auth::user();
            $data = User::where('email', $request->email)->first();
            $data->update([
                'last_login' => Carbon::now()->format('ymd H:i:s'),
            ]);
            // Generate a token using JWTAuth
            $token = JWTAuth::fromUser($user);

            $data = Customer::with('reffel')->where('user_id', $user->id)->first();
            $data['token'] = $token;
            // Return a JSON response with success and token information
            return response()->json(responseData($data, "Login successfull"));
        } else {
            // Authentication failed, return an error response
            return response()->json(responseData(null, "credential not match", false));
        }
    }

    // public function otpvalidation(Request $request)
    // {

    //     $validator = Validator::make($request->all(), [
    //         'otp' => 'required',
    //         'user_id' => 'required|exists:otps,user_id',
    //     ]);

    //     if ($validator->fails()) {
    //         $message = $validator->errors();
    //         return response()->json(responseData(null, $message, false));
    //     }
    //     $data = Otp::where('user_id', $request->user_id)->latest()->first();
    //     //$user = User::where('id', $request->user_id)->first();
    //     $user = User::where('id',$request->user_id)->first();
    //     if ($data->otp == $request->otp) {
    //         $user->update([
    //             'email_verified_at' =>Carbon::now(),
    //         ]);
    //         $data->delete();
    //         return response()->json(responseData($user, 'profile verified'));
    //     } else {
    //         return response()->json(responseData(null, "Please enter Valid OPT", false));
    //     }
    // }

    public function validationmail($email, $otp)
    {
        // try {
        $maildata = [
            'title' => 'Mail from Sprinter Online game',
            'otp' => $otp,
            //'password' => $password,
        ];

        Mail::to($email)->send(new LoginvarificationMail($maildata));
        // } catch (Throwable $t) {
        //     Log::error('mail sending fail: ' . $t->getmessage());
        // }
    }

    public function regmail($name_e, $pass, $email)
    {
        $maildata = [
            'title' => 'Mail from Sprinter Online game',
            'name' => $name_e,
            'password' => $pass,
            'email' => $email,
        ];

        Mail::to($email)->send(new RegistrationMail($maildata));
    }

    public function profile(Request $request)
    {
        try {
            $id = auth()->user()->id;
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                $message = $validator->errors();
                return response()->json(responseData(null, $message, false));
            }

            Customer::where('user_id', $id)->update([
                'first_name' => $request->name,
            ]);

            User::where('id', $id)->update([
                'name' => $request->name,
            ]);

            return response()->json(responseData(null, "Profile updated successfully"));
        } catch (\Exception $e) {
            return response()->json(responseData(null, "An error occurred while updating profile", false));
        }
    }

    public function forgotpassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            $message = $validator->errors();
            return response()->json(responseData(null, $message, false));
        } else {
            $data = User::where('email', $request->email)->first();

            $otp = rand(1000, 9999);

            if ($data) {
                $this->forgotmail($data, $otp);
                $data['otp'] = $otp;
                return response()->json(responseData($data, "otp send seccessfully"));
            } else {
                return response()->json(responseData(null, "please provide valid email id", false));
            }
        }
    }

    public function forgotmail($email, $data)
    {
        try {
            $maildata = [
                'title' => 'Mail from Sprinter Online game',
                'otp' => $data
            ];

            Mail::to($email->email)->send(new ForgotpasswordMail($maildata, $email));
        } catch (Throwable $t) {
            Log::error('mail sending fail: ' . $t->getmessage());
        }
    }

    public function resetpassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $message = $validator->errors();
            return response()->json(responseData(null, $message, false));
        } else {
            $data = User::where('email', $request->email)->first();
            $data->update([
                'password' => Hash::make($request->password),
            ]);
            return response()->json(responseData($data, "password reset successful"));
        }
    }




    public function updatepassword(Request $req)  //change password
    {
        $validator = Validator::make($req->all(), [
            'password' => 'required',
        ]);
        $id = auth()->user()->id;

        if ($validator->fails()) {
            $message = $validator->errors();
            return response()->json(responseData(null, $message, false));
        } else {
            $data = User::where('id', $id)->first();
            $data->update([
                'password' => Hash::make($req->password),
            ]);

            $this->changpassmail($data);

            Notification::create([
                'module' => 'Customer',
                'message' => 'Your password has been successfully changed for Sprinters Online',
                'is_openabl' => 'yes',
                'action' => 'change',
                'table' => 'user',
                // 'table_id' => $customer->id,
                'created_by' => $data->id,
                'user_id' => $data->id,
            ]);

            return response()->json(responseData($data, "password reset successful"));
        }
    }

    public function changpassmail($data)
    {
        // try {
        $maildata = [
            'title' => 'Mail from Sprinter Online game',
        ];

        Mail::to($data->email)->send(new ChangepasswordMail($maildata, $data));
        // } catch (Throwable $t) {
        //     Log::error('mail sending fail: ' . $t->getmessage());
        // }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(responseData(null, "logout Successfully"));
    }
}
