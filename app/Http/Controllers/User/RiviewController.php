<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\FeedbackMail;
use App\Models\Review;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class RiviewController extends Controller
{
    public function review()
    {
        $id = auth()->user()->id;
        $baseURL = request()->root();
        // $data = Review::where(function ($query) use ($id) {
        //     $query->where('user_id', $id)->orWhereNull('user_id');
        // })->where('status', 'Approved')->orderBy('review')->orderBy('type')->get();
            $celeb = Review::where('review','celeb')->where('status','Approved')->orderBy('type')->get();
            $customer = Review::where('review','customer')->where('status','Approved')->orderBy('type')->get();

        $celeb->transform(function ($review) use ($baseURL) {
            if ($review->type == 'Image') {
                $review->photo = $baseURL . '/' . $review->photo;
            }

            if ($review->type == 'Video') {
                $review->video =  'https://' . $review->video;
                $review->photo = $baseURL . '/' . $review->photo;
            }
            $review->review_type = $review->review;
            unset($review->review);

            return $review;
        });

        $customer->transform(function ($review) use ($baseURL) {
            if ($review->type == 'Image') {
                $review->photo = $baseURL . '/' . $review->photo;
            }

            if ($review->type == 'Video') {
                $review->video =  'https://' . $review->video;
                $review->photo = $baseURL . '/' . $review->photo;
            }
            $review->review_type = $review->review;
            unset($review->review);

            return $review;
        });

        $data = [
            'celeb'=> $celeb,
            'customer' => $customer
        ];


        return response()->json(responseData($data, "all Review Retrive"));
    }


    public function postreview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //'type' => 'required',
            'marks' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors();
            return response()->json(responseData(null, $message, false));
        }

        $id = auth()->user()->id;
        $name = User::where('id', $id)->first();


        $fullPath = null;
        if ($request->hasFile('photo')) {
            $imageName = time() . '.' . $request->file('photo')->extension();
            if (!File::exists("image/review")) {
                File::makeDirectory("image/review");
            }
            $request->photo->move(public_path('image/review'), $imageName);
            $fullPath = 'image/review/' . $imageName;
        }

        if (isset($request->video) && $request->video != null) {
            $type = 'Video';
        } else if (isset($request->photo) && $request->photo != null) {
            $type = 'Image';
        } else {
            $type = 'Text';
        }

        $data = Review::create([
            'type' => $type,
            'title' => $request->title,
            'content' => $request->content,
            'status' => "Pending",
            'marks' => $request->marks,
            'created_by' => $id,
            'user_id' => $id,
            'user_name' => $name->name,
            'photo' => $fullPath,
            'video' => $request->video,
            'review' => "customer"
        ]);

        Notification::create([
            'module' => 'reviews',
            'message' => 'Thank you for your feedback! Your details has been received.',
            'is_openabl' => 'yes',
            'action' => 'new_review',
            'table' => 'reviews',
            // 'table_id' => $customer->id,
            'created_by' => $id,
            'user_id' => $id,
        ]);

        $this->feedackmail($name);

        if ($data) {
            return response()->json(responseData(null, "Review submitted successfully"));
        } else {
            return response()->json(responseData(null, "some thing went wrong", false));
        }
    }

    public function feedackmail($email)
    {
        // try {
        $maildata = [
            'title' => 'Mail from Sprinter Online game',
        ];

        Mail::to($email->email)->send(new FeedbackMail($maildata, $email));
        // } catch (Throwable $t) {
        //     Log::error('mail sending fail: ' . $t->getmessage());
        // }
    }
}
