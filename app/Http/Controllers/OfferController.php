<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\User;
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



use App\Exports\OfferexcelExport;
use App\Models\AppInfo;
use Maatwebsite\Excel\Facades\Excel;

use Barryvdh\DomPDF\Facade\Pdf;


class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:offer-list|offer-create|offer-edit|offer-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:offer-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:offer-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:offer-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $data7 = Offer::orderBy('id', 'ASC')->when($request->has("name"), function ($q) use ($request) {



            $name  = $request->get("name");
            if ($name != '') {
                return $q->where("offers.name", "like", "%" . $name . "%");
            }
        })->get();
        $thearray = [];
        if (count($data7) > 0) {
            foreach ($data7 as $k2 => $v2) {


                $thearray[] = array(
                    'name' => $v2->name, 'cta_type' => $v2->cta_type, 'cta_link' => $v2->cta_link, 'description' => $v2->description, 'is_feature' => $v2->is_feature, 'status' => $v2->status, 'id' => $v2->id, 'photo' => $v2->photo ,'start_date' => $v2->start_date , 'end_date' => $v2->end_date,

                );
            }
        }
        $data = $this->paginate($thearray, 'offers.index', 10);
        $wa = (object) [
            'whats_app_1' => '+91 74290 00000'
        ];
        $whatsAppNumber = isset($wa->whats_app_1) ? $wa->whats_app_1 : '';

        if ($request->ajax()) {
            return view('offers.index-pagination', ['offers' => $data]);
        }
        return view('offers.index', ['offers' => $data, 'wa' => $wa->whats_app_1]);
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
        return view('offers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $name = $request->input('name');
        $description = $request->input('description');



        $start_end_date = $request->input('start_end_date');
        $is_feature = $request->input('is_feature');
        $cta_type = $request->input('cta_type');
        //$cta_link = $request->input('cta_link');

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
        $all_required['name'] = 'required|unique:offers,name';
        $all_required['cta_type'] = 'required';
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
                    if ($image->move(public_path() . '/image/offer/', $fileName)) {
                        $attachment_1 =  'image/offer/' . $fileName;

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

            if ($is_feature == 'Yes') {
                Offer::where('is_feature', 'Yes')->update(['is_feature' => 'No']);
            }
            $offer = Offer::create(['name' => $request->input('name'), 'start_date' => $start_date, 'end_date' => $end_date, 'is_feature' => $is_feature, 'cta_type' => $cta_type, 'cta_link' => $content, 'photo' => $photo, 'description' => $request->input('description'), 'created_by' => Auth::user()->id]);


            if ($offer->save()) {

                // $created_by = Auth::user()->id;
                // $user = User::where('id', $created_by);
                // $table_id = $offer->id;
                // Notification::create([
                //     'module' => 'Offer',
                //     'message' => 'Exciting news! New offers have been uploaded. Check them out now! Visit Our App',
                //     'is_openabl' => 'yes',
                //     'action' => 'add',
                //     'table' => 'offer',
                //     'table_id' => $table_id,
                //     'created_by' => $created_by,
                //     'user_id' => $user->id,
                // ]);

                //Notification start
                $module = 'Offer';
                $message = 'Exciting news! New offers have been uploaded. Check them out now! Visit Our App';
                $is_openabl = 'yes';
                $permissions = 'offer-list';
                $action = 'Add';
                $table = 'offers';
                $table_id = $offer->id;
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


                Session::flash('success', 'successfully offer  added!');

                return response()->json([
                    'type' => 'success',
                    'message' => 'successfully offer  added!'
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
    public function show(Offer $offer)
    {
        // $result = Offer::find($offer);
        // $asset = asset('');
        // return json_encode(array('status' => 'ok', 'data' => $result, 'asset' => $asset));
        $offer = Offer::find($offer->id);
        return view('offers.show', compact('offer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $offer = Offer::find($id);

        return view('offers.edit', compact('offer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:offers,name,' . $id,
            'description' => 'required',
            'feature' => 'required',
            'status' => 'required',

        ]);

        $offer = Offer::find($id);
        $photo = $offer->photo;




        if ($request->file('photo')) {


            $image = $request->file('photo');


            $originName = $image->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $fileName = preg_replace("/[^a-zA-Z0-9]+/", "", $fileName);

            $extension = $image->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;



            if (in_array($extension, ['png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG'])) {
                if ($image->move(public_path() . '/image/offer/', $fileName)) {
                    $attachment_1 =  'image/offer/' . $fileName;

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

        $offer->name = $request->input('name');
        $offer->description = $request->input('description');
        $offer->status = $request->input('status');
        $offer->is_feature = $request->input('feature');
        $offer->photo = $photo;
        $offer->save();

        //Notification start
        $module = 'Offer';
        $message = $module . ' updated';
        $is_openabl = 'yes';
        $permissions = 'offer-list';
        $action = 'Update';
        $table = 'offers';
        $table_id = $offer->id;
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


        return redirect()->route('offers.index')->with('success', 'Offer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer): RedirectResponse
    {
        //Notification start
        $module = 'Offer';
        $message = $module . ' deleted';
        $is_openabl = 'no';
        $permissions = 'offer-list';
        $action = 'Delete';
        $table = 'offers';
        $table_id = $offer->id;
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

        $offer->delete();



        return redirect()->route('offers.index')
            ->with('success', 'Offer deleted successfully');
    }

    public function exportexcel()
    {
        $type = $_POST['type'];
        if ($type == 'All') {


            return Excel::download(new OfferexcelExport([]), 'offer.xlsx');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            return Excel::download(new OfferexcelExport($all_ids), 'offer.xlsx');
        }
    }
    public function exportcsv()
    {

        $type = $_POST['type'];
        if ($type == 'All') {

            return Excel::download(new OfferexcelExport([]), 'offer.csv');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            return Excel::download(new OfferexcelExport($all_ids), 'offer.csv');
        }
    }
    public function exportpdf()
    {


        $type = $_POST['type'];
        if ($type == 'All') {

            $data = Offer::get()->toArray();
            $pdf = PDF::loadView('offers.pdf', ['data' => $data]);
            return $pdf->download('offer.pdf');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            $data = Offer::whereIn('id', $all_ids)->get()->toArray();
            $pdf = PDF::loadView('offers.pdf', ['data' => $data]);
            return $pdf->download('offer.pdf');
        }
    }
}
