<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Contest;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use App\Exports\PlatformexcelExport;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PlatformController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:platform-list|platform-create|platform-edit|platform-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:platform-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:platform-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:platform-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $data7 = Platform::orderBy('id', 'DESC')->when($request->has("name"), function ($q) use ($request) {



            $name  = $request->get("name");
            if ($name != '') {
                return $q->where("platforms.name", "like", "%" . $name . "%");
            }
        })->get();
        $thearray = [];
        if (count($data7) > 0) {
            foreach ($data7 as $k2 => $v2) {


                $thearray[] = array(
                    'name' => $v2->name, 'demo_details' => $v2->demo_details, 'demo_user_id' => $v2->demo_user_id, 'demo_password' => $v2->demo_password, 'description' => $v2->description, 'status' => $v2->status, 'id' => $v2->id, 'photo' => $v2->photo

                );
            }
        }
        $data = $this->paginate($thearray, 'platforms.index', 10);
        if ($request->ajax()) {
            return view('platforms.index-pagination', ['platforms' => $data]);
        }
        return view('platforms.index', ['platforms' => $data]);
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
        return view('platforms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $description = $request->input('description');



        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:platforms,name',
            'demo_details' => 'url|required',
            'demo_user_id' => 'required',
            'demo_password' => 'required'

        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            if ($errors->has('name')) {

                $all_errors[] = [
                    'id' => 'name',
                    'error_id' => 'name_error',
                    'message' => $errors->first('name')
                ];
            }

            if ($errors->has('demo_details')) {

                $all_errors[] = [
                    'id' => 'demo_details',
                    'error_id' => 'demo_details_error',
                    'message' => $errors->first('demo_details')
                ];
            }

            if ($errors->has('demo_user_id')) {

                $all_errors[] = [
                    'id' => 'demo_user_id',
                    'error_id' => 'demo_user_id_error',
                    'message' => $errors->first('demo_user_id')
                ];
            }

            if ($errors->has('demo_password')) {

                $all_errors[] = [
                    'id' => 'demo_password',
                    'error_id' => 'demo_password_error',
                    'message' => $errors->first('demo_password')
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
                    if ($image->move(public_path() . '/image/platform/', $fileName)) {
                        $attachment_1 =  'image/platform/' . $fileName;

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


            $platform = Platform::create(['name' => $request->input('name'), 'photo' => $photo, 'description' => $request->input('description'), 'demo_details' => $request->input('demo_details'), 'demo_user_id' => $request->input('demo_user_id'), 'demo_password' => $request->input('demo_password'), 'created_by' => Auth::user()->id]);


            if ($platform->save()) {

                //Notification start
                $module = 'Platform';
                $message = 'Discover more gaming options! New game platforms have been added to your Sprinters Online App';
                $is_openabl = 'yes';
                $permissions = 'platform-list';
                $action = 'Add';
                $table = 'platforms';
                $table_id = $platform->id;
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

                Session::flash('success', 'successfully platform  added!');

                return response()->json([
                    'type' => 'success',
                    'message' => 'successfully platform  added!'
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
    public function show(Platform $platform)
    {
        $platform = Platform::find($platform->id);
        return view('platforms.show', compact('platform'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $platform = Platform::find($id);

        return view('platforms.edit', compact('platform'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:platforms,name,' . $id,
        ]);

        $platform = Platform::find($id);

        $photo = $platform->photo;


        if ($request->file('photo')) {


            $image = $request->file('photo');


            $originName = $image->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $fileName = preg_replace("/[^a-zA-Z0-9]+/", "", $fileName);

            $extension = $image->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;



            if (in_array($extension, ['png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG'])) {
                if ($image->move(public_path() . '/image/platform/', $fileName)) {
                    $attachment_1 =  'image/platform/' . $fileName;

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

        $platform->name = $request->input('name');
        $platform->description = $request->input('description');
        $platform->demo_user_id = $request->input('demo_user_id');
        $platform->demo_password = $request->input('demo_password');
        $platform->demo_details = $request->input('demo_details');
        $platform->status = $request->input('status');
        $platform->photo = $photo;
        $platform->save();

        //Notification start
        $module = 'Platform';
        $message = $module . ' updated';
        $is_openabl = 'yes';
        $permissions = 'platform-list';
        $action = 'Update';
        $table = 'platforms';
        $table_id = $platform->id;
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


        return redirect()->route('platforms.index')->with('success', 'Platform updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Platform $platform): RedirectResponse
    {


        $contest_count = Contest::where('platform_id', $platform->id)->get()->count();
        if (($contest_count) == 0) {

            //Notification start
            $module = 'Platform';
            $message = $module . ' deleted';
            $is_openabl = 'no';
            $permissions = 'platform-list';
            $action = 'Delete';
            $table = 'platforms';
            $table_id = $platform->id;
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
            $platform->delete();

            return redirect()->route('platforms.index')
                ->with('success', 'Platform deleted successfully');
        } else {


            return redirect()->route('platforms.index')
                ->with('error', 'Platform could not be deleted for other places use');
        }
    }

    public function exportexcel()
    {
        $type = $_POST['type'];
        if ($type == 'All') {

            return Excel::download(new PlatformexcelExport([]), 'platform.xlsx');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            return Excel::download(new PlatformexcelExport($all_ids), 'platform.xlsx');
        }
    }

    public function exportcsv()
    {

        $type = $_POST['type'];
        if ($type == 'All') {

            return Excel::download(new PlatformexcelExport([]), 'platform.csv');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            return Excel::download(new PlatformexcelExport($all_ids), 'platform.csv');
        }
    }

    public function exportpdf()
    {
        $type = $_POST['type'];
        if ($type == 'All') {

            $data = Platform::get()->toArray();
            $pdf = PDF::loadView('platforms.pdf', ['data' => $data]);
            return $pdf->download('platform.pdf');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            $data = Platform::whereIn('id', $all_ids)->get()->toArray();
            $pdf = PDF::loadView('platforms.pdf', ['data' => $data]);
            return $pdf->download('platform.pdf');
        }
    }
}
