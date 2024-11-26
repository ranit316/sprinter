<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function catagory(){
        $catagorys = Category::where('status','Active')->get();
        //$catagorys = Category::where('status','Active')->paginate(5);
        $baseurl = request()->root();
        $catagorys->transform(function ($catagory) use ($baseurl) {
            $catagory->photo = $baseurl . '/' .$catagory->photo;
            return $catagory;
        });
       
        return response()->json(responseData($catagorys, "Category Added Successfully"));
    }
}
