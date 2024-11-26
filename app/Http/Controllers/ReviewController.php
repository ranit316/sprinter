<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Notification;

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

use App\Models\Category;
use App\Models\Platform;

use App\Exports\ReviewexcelExport;
use Maatwebsite\Excel\Facades\Excel;

use PDF;

use Illuminate\Validation\Rule;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:review-list|review-create|review-edit|review-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:review-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:review-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:review-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $data7 = Review::orderBy('id', 'DESC')->when($request->has("name"), function ($q) use ($request) {



            $name  = $request->get("name");
            if ($name != '') {
                return $q->where("reviews.content", "like", "%" . $name . "%");
            }
        })->get();
        $thearray = [];
        if (count($data7) > 0) {
            foreach ($data7 as $k2 => $v2) {


                $thearray[] = array(
                    'type' => $v2->type, 'user' => $v2->user_name, 'content' => $v2->content, 'photo' => $v2->photo, 'video' => $v2->video, 'status' => $v2->status, 'id' => $v2->id, 'marks' => $v2->marks, 'review' => $v2->review, 'title' => $v2->title

                );
            }
        }
        $data = $this->paginate($thearray, 'reviews.index', 10);

        $users = User::where('type', 'User')->orderBy('name', 'asc')->get();

        

        if ($request->ajax()) {
            return view('reviews.index-pagination', ['reviews' => $data, 'users' => $users]);
        }
        return view('reviews.index', ['reviews' => $data, 'users' => $users]);
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
        return view('reviews.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $type = $request->input('type');

        $marks = $request->input('marks');
        $user_name = $request->input('user_name');
        $review_type = $request->input('review_type');

        $all_required = [];

        $all_required['type'] = 'required';
        $all_required['user_name'] = 'required';
        $all_required['review_type'] = 'required';

        if ($type == 'Text') {
            $all_required['content'] = 'required';
        } else  if ($type == 'Image') {
            if ($request->file('photo')) {
            } else {
                $all_required['file'] = 'required';
            }
        } else  if ($type == 'Video') {
            $all_required['video'] = 'required';
            $all_required['review_type'] = 'required';
        }
        $all_required['marks'] = 'required';



        $validator = Validator::make(
            $request->all(),
            $all_required

        );

        if ($type == 'Text') {
            $content = $request->input('content');
            $video = "";
            $photo = "";
            $review_type = "";
        } else  if ($type == 'Video') {
            $content = "";
            $video = $request->input('video');
            $review_type = $request->input('review_type');
            $photo = "";
        }

        if ($validator->fails()) {

            $errors = $validator->errors();

            $all_errors = [];

            if ($errors->has('type')) {

                $all_errors[] = [
                    'id' => 'type',
                    'error_id' => 'type_error',
                    'message' => $errors->first('type')
                ];
            }
            if ($errors->has('user_name')) {

                $all_errors[] = [
                    'id' => 'user_name',
                    'error_id' => 'user_name_error',
                    'message' => $errors->first('user_name')
                ];
            }
            if ($errors->has('content')) {

                $all_errors[] = [
                    'id' => 'content',
                    'error_id' => 'content_error',
                    'message' => $errors->first('content')
                ];
            }

            if ($errors->has('video')) {

                $all_errors[] = [
                    'id' => 'video',
                    'error_id' => 'video_error',
                    'message' => $errors->first('video')
                ];
            }
            if ($errors->has('file')) {

                $all_errors[] = [
                    'id' => 'file',
                    'error_id' => 'file_error',
                    'message' => $errors->first('file')
                ];
            }
            if ($errors->has('marks')) {

                $all_errors[] = [
                    'id' => 'marks',
                    'error_id' => 'marks_error',
                    'message' => $errors->first('marks')
                ];
            }
            if ($errors->has('review_type')) {

                $all_errors[] = [
                    'id' => 'review_type',
                    'error_id' => 'review_type_error',
                    'message' => $errors->first('review_type')
                ];
            }

            return response()->json([
                'type' => 'error',
                'all_errors' => $all_errors
            ]);
        } else {

            if ($type == 'Image') {
                $content = "";
                $video = "";
                $photo = '';
                $review_type = "";

                if ($request->file('photo')) {


                    $image = $request->file('photo');


                    $originName = $image->getClientOriginalName();
                    $fileName = pathinfo($originName, PATHINFO_FILENAME);
                    $fileName = preg_replace("/[^a-zA-Z0-9]+/", "", $fileName);

                    $extension = $image->getClientOriginalExtension();
                    $fileName = $fileName . '_' . time() . '.' . $extension;



                    if (in_array($extension, ['png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG'])) {
                        if ($image->move(public_path() . '/image/review/', $fileName)) {
                            $attachment_1 =  'image/review/' . $fileName;

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
            }


            $review = Review::create(['type' => $type, 'status' => 'Approved', 'content' => $content, 'photo' => $photo, 'video' => $video, 'marks' => $marks, 'user_name' => $user_name, 'review' => $review_type ,'created_by' => Auth::user()->id]);


            if ($review->save()) {


                //Notification start
                $module = 'Review';
                $message = $module . ' added';
                $is_openabl = 'yes';
                $permissions = 'review-list';
                $action = 'Add';
                $table = 'reviews';
                $table_id = $review->id;
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

                Session::flash('success', 'successfully review  added!');

                return response()->json([
                    'type' => 'success',
                    'message' => 'successfully review  added!'
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
    public function show(Review $review)
    {

        $review = Review::find($review->id);
        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $review = Review::find($id);

        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $this->validate($request, [
            'status' => 'required',
        ]);

        $review = Review::find($id);

        if($review->created_by = 1) {
            $review->update([
                'status' =>$request->input('status')
            ]);
        }else{
            $review->status = $request->input('status');
            $review->type = $request->input('type');
            $review->marks = $request->input('marks');
            $review->user_name = $request->input('user_name');
            $review->save();
        }

       

        //Notification start
        $module = 'Review';
        $message = $module . ' updated';
        $is_openabl = 'yes';
        $permissions = 'review-list';
        $action = 'Update';
        $table = 'reviews';
        $table_id = $id;
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

        return redirect()->route('reviews.index')
            ->with('success', 'Review updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review): RedirectResponse
    {

         //Notification start
         $module = 'Review';
         $message = $module . ' deleted';
         $is_openabl = 'no';
         $permissions = 'review-list';
         $action = 'Delete';
         $table = 'reviews';
         $table_id = $review->id;
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
         
        $review->delete();

       

        return redirect()->route('reviews.index')
            ->with('success', 'Review deleted successfully');
    }

    public function exportexcel()
    {
        $type = $_POST['type'];
        if ($type == 'All') {

            return Excel::download(new ReviewexcelExport([]), 'review.xlsx');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            return Excel::download(new ReviewexcelExport($all_ids), 'review.xlsx');
        }
    }
    public function exportcsv()
    {

        $type = $_POST['type'];
        if ($type == 'All') {

            return Excel::download(new ReviewexcelExport([]), 'review.csv');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            return Excel::download(new ReviewexcelExport($all_ids), 'review.csv');
        }
    }
    public function exportpdf()
    {


        $type = $_POST['type'];
        if ($type == 'All') {

            $data = Review::get()->toArray();
            $pdf = PDF::loadView('reviews.pdf', ['data' => $data]);
            return $pdf->download('review.pdf');
        } else {
            $all_ids_str = $_POST['all_ids'];
            $all_ids = explode(',', $all_ids_str);
            $data = Review::whereIn('id', $all_ids)->get()->toArray();
            $pdf = PDF::loadView('reviews.pdf', ['data' => $data]);
            return $pdf->download('review.pdf');
        }
    }
}
