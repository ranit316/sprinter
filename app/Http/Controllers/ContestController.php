<?php

namespace App\Http\Controllers;

use App\Events\BulkNotification;
use App\Models\Contest;
use Illuminate\Http\Request;
use App\Models\Notification;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use App\Models\Category;
use App\Models\Platform;

use App\Exports\ContestexcelExport;
use Maatwebsite\Excel\Facades\Excel;

use Barryvdh\DomPDF\PDF;
use App\Models\AppInfo;


class ContestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:contest-list|contest-create|contest-edit|contest-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:contest-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:contest-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:contest-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $data7 = Contest::with('category')->orderBy('id', 'ASC')->when($request->has("name"), function ($q) use ($request) {



            $name  = $request->get("name");
            if ($name != '') {
                return $q->where("contests.name", "like", "%" . $name . "%");
            }
        })->get();
        $thearray = [];
        if (count($data7) > 0) {
            foreach ($data7 as $k2 => $v2) {


                $thearray[] = array(
                    'category_name' => $v2->category->name,'name' => $v2->name,'start_date' => $v2->start_date,'end_date' => $v2->end_date, 'description' => $v2->description, 'status' => $v2->status, 'id' => $v2->id, 'photo' => $v2->photo

                );
            }
        }
        $data = $this->paginate($thearray, 'contests.index', 10);

        $categories = Category::where('status', 'Active')->orderBy('name', 'asc')->get();
        $platforms = Platform::where('status', 'Active')->orderBy('name', 'asc')->get();
        // $wa = AppInfo::first();
        $wa = (object) [
            'whats_app_1' => '+91 74290 00000'
        ];
        $whatsAppNumber = isset($wa->whats_app_1) ? $wa->whats_app_1 : '';

        if ($request->ajax()) {
            return view('contests.index-pagination', ['contests' => $data, 'categories' => $categories, 'platforms' => $platforms]);
        }
        return view('contests.index', ['contests' => $data, 'categories' => $categories, 'platforms' => $platforms, 'wa' => $wa->whats_app_1]);
    }
    public function paginate($items, $route, $perPage = 2, $page = null, $options = [])
    {
        $options = ['path' => Route($route)];

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('contests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $description = $request->input('description');

        $category_id = $request->input('category_id');
        $platform_id = $request->input('platform_id');

        $start_end_date = $request->input('start_end_date');
        $result_link = $request->input('result_link');
        $cta_type = $request->input('cta_type');
        $price = $request->input('price');

       
      
        $all_required = [];
        $all_required['name']='required|unique:contests,name';
        $all_required['category_id']='required';
        //$all_required['platform_id']='required';
        $all_required['cta_type']='required';
        $all_required['price'] = 'required';


        if($cta_type=='Email')
        {
            $all_required['cta_email']='email|required';
        }
        else  if($cta_type=='Tel')
        {
            $all_required['cta_tel']='required|regex:/^[0-9]{10}$/';
        }
        else  if($cta_type=='Link')
        {
            $all_required['cta_link']='url|required';
        }else if($cta_type == 'WA')
        {
            $all_required['cta_wa'] = 'required';
        }
        
        $validator = Validator::make($request->all(), 
        $all_required

    );

    
   

    if($cta_type=='Email')
    {
        $content = $request->input('cta_email');
    }
    else  if($cta_type=='Tel')
    {
        $content = $request->input('cta_tel');
    }
    else  if($cta_type=='Link')
    {
        $content = $request->input('cta_link');
    }else if($cta_type == 'WA') 
    {
        $content = $request->input('cta_wa');
    }
      



        $start_date = '';
        $end_date = '';

        if ($start_end_date != '') {
            $start_end_date_array =  explode(' - ', $start_end_date);
            /*
            $start_date_temp = $start_end_date_array[0];
            $end_date_temp = $start_end_date_array[1];
            $start_date_array = explode('/',$start_date_temp);
            $start_date=$start_date_array[2].'-'.$start_date_array[0].'-'.$start_date_array[1].' 00:00:00';

            $end_date_array = explode('/',$end_date_temp);
            $end_date=$end_date_array[2].'-'.$end_date_array[0].'-'.$end_date_array[1].' 23:59:59';
            */
            $start_date = date('Y-m-d H:i:s',strtotime($start_end_date_array[0]));
            $end_date = date('Y-m-d H:i:s',strtotime($start_end_date_array[1]));
        }

        //return $start_date;



        if ($validator->fails()) {

            $errors = $validator->errors();

            $all_errors = [];

            if ($errors->has('name')) {

                $all_errors[] = [
                    'id' => 'name',
                    'error_id' => 'name_error',
                    'message' => $errors->first('name')
                ];
            }

            if ($errors->has('price')){

                $all_errors[] = [
                    'id' => 'price',
                    'error_id' => 'price_error',
                    'message' => $errors->first('price')
                ];
            }

            if ($errors->has('category_id')) {

                $all_errors[] = [
                    'id' => 'category_id',
                    'error_id' => 'category_id_error',
                    'message' => $errors->first('category_id')
                ];
            }

            // if ($errors->has('platform_id')) {

            //     $all_errors[] = [
            //         'id' => 'platform_id',
            //         'error_id' => 'platform_id_error',
            //         'message' => $errors->first('platform_id')
            //     ];
            // }

            if ($errors->has('cta_type')) {

                $all_errors[] = [
                    'id' => 'cta_type',
                    'error_id' => 'cta_type_error',
                    'message' => $errors->first('cta_type')
                ];
            }

            if ($errors->has('cta_link')) {

                $all_errors[] = [
                    'id' => 'cta_link',
                    'error_id' => 'cta_link_error',
                    'message' => $errors->first('cta_link')
                ];
            }
            if ($errors->has('cta_email')) {

                $all_errors[] = [
                    'id' => 'cta_email',
                    'error_id' => 'cta_email_error',
                    'message' => $errors->first('cta_email')
                ];
            }
            if ($errors->has('cta_tel')) {

                $all_errors[] = [
                    'id' => 'cta_tel',
                    'error_id' => 'cta_tel_error',
                    'message' => $errors->first('cta_tel')
                ];
            }
            if ($errors->has('cta_wa')) {

                $all_errors[] = [
                    'id' => 'cta_wa',
                    'error_id' => 'cta_wa_error',
                    'message' => $errors->first('cta_wa')
                ];
            }


            return response()->json([
                'type' => 'error',
                'all_errors' => $all_errors
            ]);
        } else {


            $photo = '';


            if ($request->file('photo')) {


                $image = $request->file('photo');


                $originName = $image->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $fileName = preg_replace("/[^a-zA-Z0-9]+/", "", $fileName);

                $extension = $image->getClientOriginalExtension();
                $fileName = $fileName . '_' . time() . '.' . $extension;



                if (in_array($extension, ['png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG'])) {
                    if ($image->move(public_path() . '/image/contest/', $fileName)) {
                        $attachment_1 =  'image/contest/' . $fileName;

                        $photo = $attachment_1;
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
            } else {
            }


            $contest = Contest::create(['name' => $request->input('name'), 'start_date' => $start_date, 'end_date' => $end_date, 'result_link' => $result_link, 'cta_type' => $cta_type, 'cta_link' => $content,'category_id' => $category_id, 'platform_id' => $platform_id, 'photo' => $photo, 'price' => $request->input('price'), 'description' => $request->input('description'), 'created_by' => Auth::user()->id]);


            if ($contest->save()) {

                 //Notification start
                 $module = 'Contest';
                 $message = 'Exciting news! New Contests have been uploaded. Check them out now! Visit Our App';
                 $is_openabl = 'yes';
                 $permissions = 'contest-list';
                 $action = 'Add';
                 $table = 'contests';
                 $table_id = $contest->id;
                 $created_by = Auth::user()->id;
                 $notification = Notification::create([
                     'module' => $module,
                     'message' => $message,
                     'is_openabl' => $is_openabl,
                     'permissions' => $permissions,
                     'action' => $action,
                     'table' => $table,
                     'table_id' => $table_id,
                     'created_by' => $created_by
                 ]);
                 $notification->save();
                 //Notification end
                 $push_notification = "New Contest added";
                 event(new BulkNotification($push_notification));
                Session::flash('success', 'successfully contest  added!');

                return response()->json([
                    'type' => 'success',
                    'message' => 'successfully contest  added!'
                ]);
            } else {
                Session::flash('error', 'Something wrong!');
                return response()->json([
                    'type' => 'error',
                    'message' => 'Something wrong!'
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contest $contest)
    {
        // $result = Contest::find($contest);
        // $asset = asset('');
        // return json_encode(array('status' => 'ok', 'data' => $result, 'asset' => $asset));
        $contest = Contest::find($contest->id);  
        return view('contests.show', compact('contest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $categories = Category::where('status', 'Active')->orderBy('name', 'asc')->get();
        $platforms = Platform::where('status', 'Active')->orderBy('name', 'asc')->get();

        $contest = Contest::find($id);
        return view('contests.edit', compact('contest','categories','platforms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
       
        $this->validate($request, [
            'name' => 'required|unique:contests,name,' . $id,
        ]);


       

        $contest = Contest::find($id);


        $photo = $contest->photo;


        if ($request->file('photo')) {


            $image = $request->file('photo');


            $originName = $image->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $fileName = preg_replace("/[^a-zA-Z0-9]+/", "", $fileName);

            $extension = $image->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;



            if (in_array($extension, ['png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG'])) {
                if ($image->move(public_path() . '/image/contest/', $fileName)) {
                    $attachment_1 =  'image/contest/' . $fileName;

                    $photo = $attachment_1;
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
        } else {
        }

        $contest->name = $request->input('name');
        $contest->description = $request->input('description');
        $contest->category_id = $request->input('category_id');
        $contest->platform_id = $request->input('platform_id');
        $contest->result_link = $request->input('result_link');
        $contest->status = $request->input('status');
        $contest->photo = $photo;        
        $contest->save();

         //Notification start
         $module = 'Contest';
         $message = $module . ' updated';
         $is_openabl = 'yes';
         $permissions = 'contest-list';
         $action = 'Update';
         $table = 'contests';
         $table_id = $contest->id;
         $created_by = Auth::user()->id;
         $notification = Notification::create([
             'module' => $module,
             'message' => $message,
             'is_openabl' => $is_openabl,
             'permissions' => $permissions,
             'action' => $action,
             'table' => $table,
             'table_id' => $table_id,
             'created_by' => $created_by
         ]);
         $notification->save();
         //Notification end


        return redirect()->route('contests.index') ->with('success', 'Contest updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contest $contest): RedirectResponse
    {
         //Notification start
         $module = 'Contest';
         $message = $module . ' deleted';
         $is_openabl = 'no';
         $permissions = 'contest-list';
         $action = 'Delete';
         $table = 'contests';
         $table_id = $contest->id;
         $created_by = Auth::user()->id;
         $notification = Notification::create([
             'module' => $module,
             'message' => $message,
             'is_openabl' => $is_openabl,
             'permissions' => $permissions,
             'action' => $action,
             'table' => $table,
             'table_id' => $table_id,
             'created_by' => $created_by
         ]);
         $notification->save();
         //Notification end

        $contest->delete();

        return redirect()->route('contests.index')
            ->with('success', 'Contest deleted successfully');
    }

    public function exportexcel()
    {
        $type = $_POST['type'];
        if ($type == 'All') {

            return Excel::download(new ContestexcelExport([]), 'contest.xlsx');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            return Excel::download(new ContestexcelExport($all_ids), 'contest.xlsx');
        }
    }
    public function exportcsv()
    {

        $type = $_POST['type'];
        if ($type == 'All') {

            return Excel::download(new ContestexcelExport([]), 'contest.csv');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            return Excel::download(new ContestexcelExport($all_ids), 'contest.csv');
        }
    }
    public function exportpdf()
    {


        $type = $_POST['type'];
        if ($type == 'All') {

            $data = Contest::get()->toArray();
            $pdf = PDF::loadView('contests.pdf', ['data' => $data]);
            return $pdf->download('contest.pdf');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            $data = Contest::whereIn('id', $all_ids)->get()->toArray();
            $pdf = PDF::loadView('contests.pdf', ['data' => $data]);
            return $pdf->download('contest.pdf');
        }
    }
}
