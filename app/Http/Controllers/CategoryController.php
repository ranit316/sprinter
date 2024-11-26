<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Notification;
use App\Models\Contest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\Auth;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use App\Exports\CategoryexcelExport;
use Maatwebsite\Excel\Facades\Excel;

use PDF;



class CategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {

        $data7 = Category::orderBy('id', 'ASC')->when($request->has("name"), function ($q) use ($request) {



            $name  = $request->get("name");
            if ($name != '') {
                return $q->where("categories.name", "like", "%" . $name . "%");
            }
        })->get();
        $thearray = [];
        if (count($data7) > 0) {
            foreach ($data7 as $k2 => $v2) {


                $thearray[] = array(
                    'name' => $v2->name, 'description' => $v2->description, 'status' => $v2->status, 'id' => $v2->id, 'photo' => $v2->photo

                );
            }
        }
        $data = $this->paginate($thearray, 'categories.index', 10);
        if ($request->ajax()) {
            return view('categories.index-pagination', ['categories' => $data]);
        }
        return view('categories.index', ['categories' => $data]);
    }
    public function paginate($items, $route, $perPage = 10, $page = null, $options = [])
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
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $name = $request->input('name');
        $description = $request->input('description');



        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',
            'description' => 'required',

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
            if ($errors->has('description')) {

                $all_errors[] = [
                    'id' => 'description',
                    'error_id' => 'description_error',
                    'message' => $errors->first('description')
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
                    if ($image->move(public_path() . '/image/category/', $fileName)) {
                        $attachment_1 =  'image/category/' . $fileName;

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


            $category = Category::create(['name' => $request->input('name'), 'photo' => $photo, 'description' => $request->input('description'), 'created_by' => Auth::user()->id]);


            if ($category->save()) {

                //Notification start
                $module = 'Category';
                $message = $module . ' added';
                $is_openabl = 'yes';
                $permissions = 'category-list';
                $action = 'Add';
                $table = 'categories';
                $table_id = $category->id;
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
                Session::flash('success', 'successfully category  added!');

                return response()->json([
                    'type' => 'success',
                    'message' => 'successfully category  added!'
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
    public function show(Category $category)
    {
        // $category = Category::find($id);
        //$result = Category::find($category);
        //return $categories;
        // $asset = asset('');
        // return json_encode(array('status' => 'ok', 'data' => $result, 'asset' => $asset));

        $category = Category::find($category->id);  
        return view('categories.show', compact('category'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $category = Category::find($id);

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|unique:categories,name,' . $id,
            'description' => 'required'
        ]);



        $category = Category::find($id);

        $photo = $category->photo;


        if ($request->file('photo')) {


            $image = $request->file('photo');


            $originName = $image->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $fileName = preg_replace("/[^a-zA-Z0-9]+/", "", $fileName);

            $extension = $image->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;



            if (in_array($extension, ['png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG'])) {
                if ($image->move(public_path() . '/image/category/', $fileName)) {
                    $attachment_1 =  'image/category/' . $fileName;

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


        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->status = $request->input('status');
        $category->photo = $photo;
        $category->save();

        //Notification start
        $module = 'Category';
        $message = $module . ' updated';
        $is_openabl = 'yes';
        $permissions = 'category-list';
        $action = 'Update';
        $table = 'categories';
        $table_id = $category->id;
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


        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {

        $category_id = $category->id;

        //echo $category_id;
        // echo "<br>";

        $contest_count = Contest::where('category_id', $category_id)->get()->count();
        $event_count = Event::where('category_id', $category_id)->get()->count();
        if (($contest_count + $event_count) == 0) {

            //Notification start
            $module = 'Category';
            $message = $module . ' deleted';
            $is_openabl = 'no';
            $permissions = 'category-list';
            $action = 'Delete';
            $table = 'categories';
            $table_id = $category->id;
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
            $category->delete();

            return redirect()->route('categories.index')
                ->with('success', 'Category deleted successfully');
        } else {


            return redirect()->route('categories.index')
                ->with('error', 'Category could not be deleted for other places use');
        }
    }
    public function exportexcel()
    {
        $type = $_POST['type'];
        if ($type == 'All') {

            return Excel::download(new CategoryexcelExport([]), 'category.xlsx');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            return Excel::download(new CategoryexcelExport($all_ids), 'category.xlsx');
        }
    }
    public function exportcsv()
    {

        $type = $_POST['type'];
        if ($type == 'All') {

            return Excel::download(new CategoryexcelExport([]), 'category.csv');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            return Excel::download(new CategoryexcelExport($all_ids), 'category.csv');
        }
    }
    public function exportpdf()
    {


        $type = $_POST['type'];
        if ($type == 'All') {

            $data = Category::get()->toArray();
            $pdf = PDF::loadView('categories.pdf', ['data' => $data]);
            return $pdf->download('category.pdf');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            $data = Category::whereIn('id', $all_ids)->get()->toArray();
            $pdf = PDF::loadView('categories.pdf', ['data' => $data]);
            return $pdf->download('category.pdf');
        }
    }
}
