<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FaqCategoryExport;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


use Barryvdh\DomPDF\PDF;



class FaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    function __construct()
    {
        $this->middleware('permission:-list|faq-category-create|faq-category-edit|faq-category-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:faq-category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:faq-category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:faq-category-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request): View
    {

        $data7 = FaqCategory::orderBy('id', 'ASC')->when($request->has("name"), function ($q) use ($request) {



            $name  = $request->get("name");
            if ($name != '') {
                return $q->where("faq_categories.name", "like", "%" . $name . "%");
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
        $data = $this->paginate($thearray, 'faq_category.index', 10);
        if ($request->ajax()) {
            return view('faq_category.index-pagination', ['categories' => $data]);
        }
        return view('faq_category.index', ['categories' => $data]);
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
        return view('Faq_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $name = $request->input('name');
        $description = $request->input('description');



        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:faq_categories,name',
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


            $category = FaqCategory::create(['name' => $request->input('name'), 'photo' => $photo, 'description' => $request->input('description'), 'created_by' => Auth::user()->id]);


            if ($category->save()) {

                //Notification start
                $module = 'FAQ Category';
                $message = $module . ' added';
                $is_openabl = 'yes';
                $permissions = 'faq-category-list';
                $action = 'Add';
                $table = 'faq_categories';
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
    public function show(FaqCategory $faq_category)
    {
        $faq_category = FaqCategory::find($faq_category->id);
        return view('faq_category.show', compact('faq_category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $category = FaqCategory::find($id);

        return view('faq_category.edit', compact('category'));
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



        $category = FaqCategory::find($id);

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
        //  $category->photo =$photo;
        $category->save();

        //Notification start
        $module = 'FAQ Category';
        $message = $module . ' updated';
        $is_openabl = 'yes';
        $permissions = 'faq-category-list';
        $action = 'Update';
        $table = 'faq_categories';
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


        return redirect()->route('faq_category.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FaqCategory $faq_category): RedirectResponse
    {
        //echo $faq_category->name;
        //die();



        $category_id = $faq_category->id;

        //echo $category_id;
        // echo "<br>";


        $faq_count = Faq::where('category_id', $category_id)->get()->count();
        if ($faq_count == 0) {

            //Notification start
            $module = 'FAQ Category';
            $message = $module . ' deleted';
            $is_openabl = 'no';
            $permissions = 'faq-category-list';
            $action = 'Delete';
            $table = 'faq_categories';
            $table_id = $faq_category->id;
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

            $faq_category->delete();

            return redirect()->route('faq_category.index')
                ->with('success', 'Category deleted successfully');
        } else {


            return redirect()->route('faq_category.index')
                ->with('error', 'Category could not be deleted for other places use');
        }
    }
    public function exportexcel()
    {
        $type = $_POST['type'];
        if ($type == 'All') {

            return Excel::download(new FaqCategoryExport([]), 'faqcategory.xlsx');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            return Excel::download(new FaqCategoryExport($all_ids), 'faqcategory.xlsx');
        }
    }
    public function exportcsv()
    {

        $type = $_POST['type'];
        if ($type == 'All') {

            return Excel::download(new FaqCategoryExport([]), 'faqcategory.csv');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            return Excel::download(new FaqCategoryExport($all_ids), 'faqcategory.csv');
        }
    }
    public function exportpdf()
    {


        $type = $_POST['type'];
        if ($type == 'All') {

            $data = FaqCategory::get()->toArray();
            $pdf = PDF::loadView('faq_category.pdf', ['data' => $data]);
            return $pdf->download('faq_category.pdf');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            $data = FaqCategory::whereIn('id', $all_ids)->get()->toArray();
            $pdf = PDF::loadView('faq_category.pdf', ['data' => $data]);
            return $pdf->download('fq_category.pdf');
        }
    }
}
