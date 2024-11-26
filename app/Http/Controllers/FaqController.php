<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Models\Notification;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
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

use App\Models\FaqCategory;

use App\Models\Type;
use App\Exports\FaqexcelExport;
use Maatwebsite\Excel\Facades\Excel;

use PDF;


class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:faq-list|faq-create|faq-edit|faq-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:faq-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:faq-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:faq-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $data7 = Faq::with('category','type')->orderBy('id', 'ASC')->when($request->has("name"), function ($q) use ($request) {



            $name  = $request->get("name");
            if ($name != '') {
                return $q->where("faqs.name", "like", "%" . $name . "%");
            }
        })->get();
        $thearray = [];
        if (count($data7) > 0) {
            foreach ($data7 as $k2 => $v2) {


                $thearray[] = array(

                    'category_name' => $v2->category->name, 'name' => $v2->name, 'description' => $v2->description, 'status' => $v2->status, 'id' => $v2->id, 'type' => $v2->type->name


                );
            }
        }
        $data = $this->paginate($thearray, 'faqs.index', 10);

        $categories = FaqCategory::where('status', 'Active')->orderBy('name', 'asc')->get();
        $types = Type::where('status', 'Active')->orderBy('name', 'asc')->get();

        if ($request->ajax()) {
            return view('faqs.index-pagination', ['faqs' => $data, 'categories' => $categories]);
        }
        return view('faqs.index', ['faqs' => $data, 'categories' => $categories, 'types' => $types]);
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
        return view('faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $description = $request->input('description');

        $category_id = $request->input('category_id');


        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:faqs,name',
            'category_id' => 'required',


        ]);

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
            if ($errors->has('category_id')) {

                $all_errors[] = [
                    'id' => 'category_id',
                    'error_id' => 'category_id_error',
                    'message' => $errors->first('category_id')
                ];
            }



            return response()->json([
                'type' => 'error',
                'all_errors' => $all_errors
            ]);
        } else {




            $faq = Faq::create(['name' => $request->input('name'),  'category_id' => $category_id, 'description' => $request->input('description'), 'created_by' => Auth::user()->id, 'type_id' => $request->type ]);


            if ($faq->save()) {

                //Notification start
                $module = 'FAQ';
                $message = $module . ' added';
                $is_openabl = 'yes';
                $permissions = 'faq-list';
                $action = 'Add';
                $table = 'faqs';
                $table_id = $faq->id;
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
                Session::flash('success', 'successfully FAQ  added!');

                return response()->json([
                    'type' => 'success',
                    'message' => 'successfully FAQ  added!'
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
    public function show(Faq $faq)
    {
        $result = Faq::find($faq->id);
        return view('faqs.show', compact('result'));
        // $asset = asset('');
        // return json_encode(array('status' => 'ok', 'data' => $result, 'asset' => $asset));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $faq = Faq::find($id);
        $categories = FaqCategory::where('status', 'Active')->orderBy('name', 'asc')->get();
        //return $faq;
        return view('faqs.edit', compact('faq','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:faqs,name,' . $id,
        ]);

        $faq = Faq::find($id);

        $faq->name = $request->input('name');
        $faq->description = $request->input('description');
        $faq->status = $request->input('status');
        $faq->category_id  = $request->input('category_id');
        $faq->save();

        //Notification start
        $module = 'FAQ';
        $message = $module . ' updated';
        $is_openabl = 'yes';
        $permissions = 'faq-list';
        $action = 'Update';
        $table = 'faqs';
        $table_id = $faq->id;
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


        return redirect()->route('faqs.index')
            ->with('success', 'Faq updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq): RedirectResponse
    {
        //Notification start
        $module = 'FAQ';
        $message = $module . ' deleted';
        $is_openabl = 'no';
        $permissions = 'faq-list';
        $action = 'Delete';
        $table = 'faqs';
        $table_id = $faq->id;
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
        $faq->delete();

        return redirect()->route('faqs.index')
            ->with('success', 'FAQ deleted successfully');
    }

    public function exportexcel()
    {
        $type = $_POST['type'];
        if ($type == 'All') {

            return Excel::download(new FaqexcelExport([]), 'faq.xlsx');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            return Excel::download(new FaqexcelExport($all_ids), 'faq.xlsx');
        }
    }
    public function exportcsv()
    {

        $type = $_POST['type'];
        if ($type == 'All') {

            return Excel::download(new FaqexcelExport([]), 'faq.csv');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            return Excel::download(new FaqexcelExport($all_ids), 'faq.csv');
        }
    }
    public function exportpdf()
    {


        $type = $_POST['type'];
        if ($type == 'All') {

            $data = Faq::get()->toArray();
            $pdf = PDF::loadView('faqs.pdf', ['data' => $data]);
            return $pdf->download('faq.pdf');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            $data = Faq::whereIn('id', $all_ids)->get()->toArray();
            $pdf = PDF::loadView('faqs.pdf', ['data' => $data]);
            return $pdf->download('faq.pdf');
        }
    }
    public function category($type){
        //return $type;
        $data = Type::where('id',$type)->first();

        if($data->name == "Feedback"){
            $category = FaqCategory::where('name',$data->name)->get();
        }else{
            $category = FaqCategory::where('name', '!=', "Feedback")->get();
        }

        return response()->json($category);
    }
}
