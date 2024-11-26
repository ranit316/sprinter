<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\AppInfo;
use Illuminate\Support\Facades\Session;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shows = AppInfo::get();
        return view('support.support',compact('shows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $email = $request->input('email');
        $phone = $request->input('phone');
        $whats_app_no_1 = $request->input('whats_app_1');
        $whats_app_no_2 = $request->input('whats_app_2');
        $whats_app_no_3 = $request->input('whats_app_3');
        $whats_app_no_4 = $request->input('whats_app_4');
        $whats_app_no_5 = $request->input('whats_app_5');
        $whats_app_no_6 = $request->input('whats_app_6');
 
        $support_info = AppInfo::first();
 
        $support_info->email = $email;
        $support_info->phone = $phone;
        $support_info->whats_app_1 = $whats_app_no_1;
        $support_info->whats_app_2 = $whats_app_no_2;
        $support_info->whats_app_3 = $whats_app_no_3;
        $support_info->whats_app_4 = $whats_app_no_4;        
        $support_info->whats_app_5 = $whats_app_no_5;
        $support_info->whats_app_6 = $whats_app_no_6;
        $support_info->save();
 
        Session::flash('success' , 'Successfully support info updated');
        return redirect()->route('support-whatsapp.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    //   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
