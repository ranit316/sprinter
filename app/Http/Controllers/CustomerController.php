<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Auth;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\PDF;
use App\Models\Category;
use App\Models\Platform;
use App\Models\RefferalCode;
use App\Exports\CustomerexcelExport;
use Maatwebsite\Excel\Facades\Excel;



class CustomerController extends Controller
{

    public $reff_id;
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:customer-list|customer-create|customer-edit|customer-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:customer-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:customer-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $data7 = Customer::with('user')->orderBy('id', 'DESC')->when($request->has("name"), function ($q) use ($request) {



            $name  = $request->get("name");
            if ($name != '') {
                return $q->where("customers.first_name", "like", "%" . $name . "%")->orWhere("customers.last_name", "like", "%" . $name . "%");
            }
        })->get();

        $referredCounts = [];
        foreach ($data7 as $customer) {
            $ref_id = $customer->ref_id;
            if ($ref_id !== null) {
                if (!isset($referredCounts[$ref_id])) {
                    $referredCounts[$ref_id] = 1;
                } else {
                    $referredCounts[$ref_id]++;
                }
            }
        }

        $thearray = [];
        if (count($data7) > 0) {
            foreach ($data7 as $k2 => $v2) {


                $thearray[] = array(
                    'address' => $v2->address, 'first_name' => $v2->first_name, 'last_name' => $v2->last_name, 'email' => $v2->user->email, 'status' => $v2->status, 'id' => $v2->id, 'phone_number' => $v2->phone_number, 'last_login' => $v2->user->last_login,'referred_count' => isset($referredCounts[$v2->id]) ? $referredCounts[$v2->id] : 0

                );
            }
        }
        $data = $this->paginate($thearray, 'customers.index', 10);

        if ($request->ajax()) {
            return view('customers.index-pagination', ['customers' => $data]);
        }
        return view('customers.index', ['customers' => $data]);
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
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $phone_number = $request->input('phone_number');
        $address = $request->input('address');
        $email = $request->input('email');
        $password = $request->input('password');
        $status = $request->input('status');
        $ref_id = substr($first_name, 0, 4) . rand(1000, 9999);
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'status' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            $all_errors = [];

            if ($errors->has('first_name')) {

                $all_errors[] = [
                    'id' => 'first_name',
                    'error_id' => 'first_name_error',
                    'message' => $errors->first('first_name')
                ];
            }
            if ($errors->has('email')) {

                $all_errors[] = [
                    'id' => 'email',
                    'error_id' => 'email_error',
                    'message' => $errors->first('email')
                ];
            }

            if ($errors->has('password')) {

                $all_errors[] = [
                    'id' => 'password',
                    'error_id' => 'password_error',
                    'message' => $errors->first('password')
                ];
            }

            return response()->json([
                'type' => 'error',
                'all_errors' => $all_errors
            ]);
        } else {


            $name = $first_name . ' ' . $last_name;
            $password = Hash::make($password);
            $user = User::create(['name' => $name, 'type' => 'Customer', 'email' => $email, 'password' => $password, 'status' => $status]);
            $user->save();
            $user_id = $user->id;

            $customer = Customer::create(['user_id' => $user_id, 'first_name' => $first_name, 'last_name' => $last_name, 'address' => $address, 'phone_number' => $phone_number, 'status' => $status, 'created_by' => Auth::user()->id,]);

            //$reff_id = Customer::where('ref_id',$reffer_no->id)->first();
            $reffel_code = substr($name, 0, 4) . rand(1000, 9999);

            $ref_code = RefferalCode::create([
                'cus_id' => $customer->id,
                'ref_code' => $reffel_code,
            ]);

            if ($ref_code) {

                //Notification start
                $module = 'Customer';
                $message = $module . ' added';
                $is_openabl = 'yes';
                $permissions = 'customer-list';
                $action = 'Add';
                $table = 'customers';
                $table_id = $customer->id;
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
                if ($notification->save()) {
                    $reffer_no = new RefferalCode();
                    $reffer_no->ref_code = $ref_id;
                    $reffer_no->cus_id = $customer->id;
                    $reffer_no->save();
                }
                // $this->reff_id = Customer::where('ref_id',$reffer_no->id)->first();

                Session()->flash('success', 'successfully customer  added!');

                return response()->json([
                    'type' => 'success',
                    'message' => 'successfully customer  added!'
                ]);
            } else {
                Session()->flash('error', 'Something wrong!');
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
    public function show(Customer $customer)
    {
        // $result = Customer::find($customer);
        // $asset = asset('');
        // return json_encode(array('status' => 'ok', 'data' => $result, 'asset' => $asset));
        $customer = Customer::find($customer->id);
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $customer = Customer::with('user')->where('id', $id)->first();

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
        ]);

        $customer = Customer::find($id);
        $user  = User::where('id', $customer->user_id)->first();
        $customer->first_name = $request->input('first_name');
        $customer->last_name = $request->input('last_name');
        $customer->address = $request->input('address');
        $customer->phone_number = $request->input('phone_number');
        $customer->status = $request->input('status');

        $customer->status = $request->input('status');
        $user->email = $request->input('email');
        $customer->save();
        $user->save();

        //Notification start
        $module = 'Customer';
        $message = $module . ' updated';
        $is_openabl = 'yes';
        $permissions = 'customer-list';
        $action = 'Update';
        $table = 'customers';
        $table_id = $customer->id;
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


        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        //Notification start
        $module = 'Customer';
        $message = $module . ' deleted';
        $is_openabl = 'no';
        $permissions = 'customer-list';
        $action = 'Delete';
        $table = 'customers';
        $table_id = $customer->id;
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

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully');
    }

    public function exportexcel()
    {
        $type = $_POST['type'];
        if ($type == 'All') {

            return Excel::download(new CustomerexcelExport([]), 'customer.xlsx');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            return Excel::download(new CustomerexcelExport($all_ids), 'customer.xlsx');
        }
    }
    public function exportcsv()
    {

        $type = $_POST['type'];
        if ($type == 'All') {

            return Excel::download(new CustomerexcelExport([]), 'customer.csv');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            return Excel::download(new CustomerexcelExport($all_ids), 'customer.csv');
        }
    }
    public function exportpdf()
    {


        $type = $_POST['type'];
        if ($type == 'All') {

            $data = Customer::get()->toArray();
            $pdf = PDF::loadView('customers.pdf', ['data' => $data]);
            return $pdf->download('customer.pdf');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            $data = Customer::whereIn('id', $all_ids)->get()->toArray();
            $pdf = PDF::loadView('customers.pdf', ['data' => $data]);
            return $pdf->download('customer.pdf');
        }
    }

    public function refferel_list($id)
    {

        $data = Customer::with('user')->where('ref_id',$id)->where('status','Active')->get();

        return view ('customers.customerrefferel',['customers' => $data]);
    }
}
