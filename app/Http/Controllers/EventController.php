<?php

namespace App\Http\Controllers;

use App\Models\Event;
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

use App\Models\Category;
use App\Models\Platform;

use App\Exports\EventexcelExport;
use Maatwebsite\Excel\Facades\Excel;

use Barryvdh\DomPDF\PDF;
use App\Models\AppInfo;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:event-list|event-create|event-edit|event-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:event-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:event-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:event-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $data7 = Event::with('category')->orderBy('id', 'ASC')->when($request->has("name"), function ($q) use ($request) {

            $name  = $request->get("name");
            if ($name != '') {
                return $q->where("events.name", "like", "%" . $name . "%");
            }
        })->get();
        $thearray = [];
        if (count($data7) > 0) {
            foreach ($data7 as $k2 => $v2) {


                $thearray[] = array(
                    'category_name' => $v2->category->name, 'name' => $v2->name, 'cta_type' => $v2->cta_type, 'cta_link' => $v2->cta_link, 'description' => $v2->description, 'status' => $v2->status, 'id' => $v2->id, 'photo' => $v2->photo , 'start_date' =>$v2->start_date, 'end_date' => $v2->end_date, 

                );
            }
        }
        $data = $this->paginate($thearray, 'events.index', 10);

        $categories = Category::where('status', 'Active')->orderBy('name', 'asc')->get();
        $wa = (object) [
            'whats_app_1' => '+91 74290 00000'
        ];
        $whatsAppNumber = isset($wa->whats_app_1) ? $wa->whats_app_1 : '';
        
        if ($request->ajax()) {
            return view('events.index-pagination', ['events' => $data, 'categories' => $categories]);
        }
        return view('events.index', ['events' => $data, 'categories' => $categories, 'wa' => $wa->whats_app_1]);
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
        return view('events.create');
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
        $cta_type = $request->input('cta_type');


        $start_date = '';
        $end_date = '';

        if ($start_end_date != '') {
            $start_end_date_array =  explode(' - ', $start_end_date);

            $start_date_temp = $start_end_date_array[0];
            $end_date_temp = $start_end_date_array[1];
            $start_date_array = explode('/', $start_date_temp);
            $start_date = $start_date_array[2] . '-' . $start_date_array[0] . '-' . $start_date_array[1] . ' 00:00:00';

            $end_date_array = explode('/', $end_date_temp);
            $end_date = $end_date_array[2] . '-' . $end_date_array[0] . '-' . $end_date_array[1] . ' 23:59:59';
        }


        $all_required = [];
        $all_required['name'] = 'required|unique:events,name';
        $all_required['cta_type'] = 'required';
        $all_required['category_id'] = 'required';
        $all_required['photo'] = 'required';

        if ($cta_type == 'Email') {
            $all_required['cta_email'] = 'email|required';
        } else  if ($cta_type == 'Tel') {
            $all_required['cta_tel'] = 'required|regex:/^[0-9]{10}$/';
        } else  if ($cta_type == 'Link') {
            $all_required['cta_link'] = 'url|required';
        } else if ($cta_type == 'WA') {
            $all_required['cta_wa'] = 'required';
        }

        $validator = Validator::make(
            $request->all(),
            $all_required

        );




        if ($cta_type == 'Email') {
            $content = $request->input('cta_email');
        } else  if ($cta_type == 'Tel') {
            $content = $request->input('cta_tel');
        } else  if ($cta_type == 'Link') {
            $content = $request->input('cta_link');
        } else if ($cta_type == 'WA') {
            $content = $request->input('cta_wa');
        }






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
                    if ($image->move(public_path() . '/image/event/', $fileName)) {
                        $attachment_1 =  'image/event/' . $fileName;

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


            $event = Event::create(['name' => $request->input('name'), 'start_date' => $start_date, 'end_date' => $end_date, 'cta_type' => $cta_type, 'cta_link' => $content, 'category_id' => $category_id,  'photo' => $photo, 'description' => $request->input('description'), 'created_by' => Auth::user()->id]);


            if ($event->save()) {

                //Notification start
                $module = 'Event';
                $message = 'Exciting news! New Event have been uploaded. Check them out now! Visit Our App';
                $is_openabl = 'yes';
                $permissions = 'event-list';
                $action = 'Add';
                $table = 'events';
                $table_id = $event->id;
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
                Session::flash('success', 'successfully event  added!');

                return response()->json([
                    'type' => 'success',
                    'message' => 'successfully event  added!'
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
    public function show(Event $event)
    {
        // $result = Event::find($event);
        // $asset = asset('');
        // return json_encode(array('status' => 'ok', 'data' => $result, 'asset' => $asset));
        $event = Event::find($event->id);
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $event = Event::find($id);
        $catagory = Category::where('status', 'Active')->orderBy('name', 'asc')->get();
        //return ($catagory);
        return view('events.edit', compact('event', 'catagory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:offers,name,' . $id,
            'description' => 'required',
            'category_id' => 'required',
            'status' => 'required',
        ]);

        $event = Event::find($id);
        $photo = $event->photo;

        if ($request->file('photo')) {
            $image = $request->file('photo');

            $originName = $image->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $fileName = preg_replace("/[^a-zA-Z0-9]+/", "", $fileName);

            $extension = $image->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            if (in_array($extension, ['png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG'])) {
                if ($image->move(public_path() . '/image/event/', $fileName)) {
                    $attachment_1 =  'image/event/' . $fileName;

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
        }

        $event->name = $request->input('name');
        $event->description = $request->input('description');
        $event->status = $request->input('status');
        $event->category_id = $request->input('category_id');
        $event->photo = $photo;
        $event->save();


        //Notification start
        $module = 'Event';
        $message = $module . ' updated';
        $is_openabl = 'yes';
        $permissions = 'event-list';
        $action = 'Update';
        $table = 'events';
        $table_id = $event->id;
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


        return redirect()->route('events.index')->with('success', 'Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): RedirectResponse
    {
        //Notification start
        $module = 'Event';
        $message = $module . ' deleted';
        $is_openabl = 'no';
        $permissions = 'event-list';
        $action = 'Delete';
        $table = 'events';
        $table_id = $event->id;
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
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully');
    }

    public function exportexcel()
    {
        $type = $_POST['type'];
        if ($type == 'All') {

            return Excel::download(new EventexcelExport([]), 'event.xlsx');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            return Excel::download(new EventexcelExport($all_ids), 'event.xlsx');
        }
    }
    public function exportcsv()
    {

        $type = $_POST['type'];
        if ($type == 'All') {

            return Excel::download(new EventexcelExport([]), 'event.csv');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            return Excel::download(new EventexcelExport($all_ids), 'event.csv');
        }
    }
    public function exportpdf()
    {


        $type = $_POST['type'];
        if ($type == 'All') {

            $data = Event::get()->toArray();
            $pdf = PDF::loadView('events.pdf', ['data' => $data]);
            return $pdf->download('event.pdf');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            $data = Event::whereIn('id', $all_ids)->get()->toArray();
            $pdf = PDF::loadView('events.pdf', ['data' => $data]);
            return $pdf->download('event.pdf');
        }
    }
}
