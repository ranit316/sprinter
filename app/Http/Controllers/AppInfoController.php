<?php

namespace App\Http\Controllers;

use App\Models\AppInfo;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;




class AppInfoController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $appinfo = AppInfo::first();

        return view('settings.appinfo', ['appinfo' => $appinfo]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(Request $request)
    {

        $title = $request->input('title');
        $description = $request->input('description');
        $version = $request->input('version');
        $beta_url = $request->input('beta_url');
        $playstore_url = $request->input('playstore_url');
        $appstore_url = $request->input('appstore_url');

        $logo_remove = $request->input('logo_remove');
        $dark_logo_remove = $request->input('dark_logo_remove');
        $fav_icon_remove = $request->input('fav_icon_remove');
        $footer_left = $request->input('footer_left');
        $cc_email = $request->input('cc');
        $bcc_email = $request->input('bcc');
        

        // $email = $request->input('email');
        // $phone = $request->input('phone');
        // $whats_app_1 = $request->input('whats_app_1');
        // $whats_app_2 = $request->input('whats_app_2');
        // $whats_app_3 = $request->input('whats_app_3');
        // $whats_app_4 = $request->input('whats_app_4');
        // $whats_app_5 = $request->input('whats_app_5');
        // $whats_app_6 = $request->input('whats_app_6');
      


        $appinfo = AppInfo::first();

        //echo "<pre>";
        //print_r($_POST);
        //die();


        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',

        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
        } else {


            $logo = $appinfo->logo;
            if ($request->file('logo')) {

                $image = $request->file('logo');
                $originName = $image->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $fileName = preg_replace("/[^a-zA-Z0-9]+/", "", $fileName);

                $extension = $image->getClientOriginalExtension();
                $fileName = $fileName . '_' . time() . '.' . $extension;

                if (in_array($extension, ['png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG'])) {
                    if ($image->move(public_path() . '/image/settings/', $fileName)) {
                        $attachment_1 =  'image/settings/' . $fileName;

                        $logo = $attachment_1;
                    } else {
                        Session::flash('error', 'file  couldn\'t save, please try again later!');
                        return response()->json([
                            'type' => 'error',
                            'message' => 'file  couldn\'t save, please try again later!'
                        ]);
                    }
                } else {
                    Session::flash('error', 'Only allow JPG,JPEG,PNG files');
                    return response()->json([
                        'type' => 'error',
                        'message' => 'Only allow JPG,JPEG,PNG files'
                    ]);
                }
            }
            else{
                if($logo_remove==1)
                {
                    $logo ='';
                }
            }

            $dark_logo = $appinfo->dark_logo;
            if ($request->file('dark_logo')) {

                $image = $request->file('dark_logo');
                $originName = $image->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $fileName = preg_replace("/[^a-zA-Z0-9]+/", "", $fileName);

                $extension = $image->getClientOriginalExtension();
                $fileName = $fileName . '_' . time() . '.' . $extension;

                if (in_array($extension, ['png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG'])) {
                    if ($image->move(public_path() . '/image/settings/', $fileName)) {
                        $attachment_1 =  'image/settings/' . $fileName;

                        $dark_logo = $attachment_1;
                    } else {
                        Session::flash('error', 'file  couldn\'t save, please try again later!');
                        return response()->json([
                            'type' => 'error',
                            'message' => 'file  couldn\'t save, please try again later!'
                        ]);
                    }
                } else {
                    Session::flash('error', 'Only allow JPG,JPEG,PNG files');
                    return response()->json([
                        'type' => 'error',
                        'message' => 'Only allow JPG,JPEG,PNG files'
                    ]);
                }
            }
            else{
                if($dark_logo_remove==1)
                {
                    $dark_logo ='';
                }
            }

            $fav_icon = $appinfo->fav_icon;
            if ($request->file('fav_icon')) {

                $image = $request->file('fav_icon');
                $originName = $image->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $fileName = preg_replace("/[^a-zA-Z0-9]+/", "", $fileName);

                $extension = $image->getClientOriginalExtension();
                $fileName = $fileName . '_' . time() . '.' . $extension;

                if (in_array($extension, ['png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG'])) {
                    if ($image->move(public_path() . '/image/settings/', $fileName)) {
                        $attachment_1 =  'image/settings/' . $fileName;

                        $fav_icon = $attachment_1;
                    } else {
                        Session::flash('error', 'file  couldn\'t save, please try again later!');
                        return response()->json([
                            'type' => 'error',
                            'message' => 'file  couldn\'t save, please try again later!'
                        ]);
                    }
                } else {
                    Session::flash('error', 'Only allow JPG,JPEG,PNG files');
                    return response()->json([
                        'type' => 'error',
                        'message' => 'Only allow JPG,JPEG,PNG files'
                    ]);
                }
            }
            else{
                if($fav_icon_remove==1)
                {
                    $fav_icon ='';
                }
            }



            $appinfo->title = $title;
            $appinfo->description = $description;
            $appinfo->version = $version;
            $appinfo->beta_url = $beta_url;
            $appinfo->playstore_url = $playstore_url;
            $appinfo->appstore_url = $appstore_url;
            $appinfo->logo = $logo;
            $appinfo->dark_logo = $dark_logo;
            $appinfo->fav_icon = $fav_icon;
            $appinfo->footer_left = $footer_left;
            $appinfo->cc_email = $cc_email;
            $appinfo->bcc_email = $bcc_email;
            // $appinfo->email = $email;
            // $appinfo->phone = $phone;
            // $appinfo->whats_app_1 = $whats_app_1;
            // $appinfo->whats_app_2 = $whats_app_2;
            // $appinfo->whats_app_3 = $whats_app_3;
            // $appinfo->whats_app_4 = $whats_app_4;
            // $appinfo->whats_app_5 = $whats_app_5;
            // $appinfo->whats_app_6 = $whats_app_6;

            $appinfo->save();

            Session::flash('success', 'successfully app info updated');

            return redirect()->route('appinfo.index');

         
        }
    }

    
}
