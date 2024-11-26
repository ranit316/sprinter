<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class ReferalController extends Controller
{
    public function list()
    {
        $id = auth()->user()->id;
        $cus = Customer::with('reffel')->where('user_id',$id)->first();

        $count = Customer::where('ref_id',$cus->id)->where('status','Active')->count();

        $data['customer'] = $cus;
        $data['count'] = $count;

        if($data)
        {
            return response()->json(responseData($data,"all data retrive successfull"));
        }else{
            return response()->json(responseData(null,"something went wrong",false));
        }
    }
}
