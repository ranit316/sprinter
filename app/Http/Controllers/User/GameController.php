<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Event;
use App\Models\Offer;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Platform;

class GameController extends Controller
{
    public function dashboard()
    {

        $baseURL = request()->root();
        $contests = Contest::with('platform', 'category')->take(5)->get();
        $contests->transform(function ($contest) use ($baseURL) {
            $contest->photo = $baseURL . '/' . $contest->photo;
            if ($contest->cta_type == 'Link') {
                $contest->cta_link = "http://" . $contest->cta_link;
            }
            $contest->description = strip_tags($contest->description);
            // if ($contest->platfrom) {
            //     $contest->platform->photo = $baseURL . '/' . $contest->platform->photo;
            // }
            if ($contest->platform && !filter_var($contest->platform->photo, FILTER_VALIDATE_URL)) {
                $contest->platform->photo = $baseURL . '/' . $contest->platform->photo;
            }
            $contest->category->photo = $baseURL . '/' . $contest->category->photo;
            return $contest;
        });

        $offers = Offer::where('status', 'Active')->take(5)->get();

        $offers->transform(function ($offer) use ($baseURL) {
            $offer->photo = $baseURL . '/' . $offer->photo;
            $offer->description = strip_tags($offer->description);
            return $offer;
        });

        $events = Event::with('category')->where('status', 'Active')->take(5)->get();
        $events->transform(function ($event) use ($baseURL) {
            $event->photo = $baseURL . '/' . $event->photo;
            if ($event->cta_type == 'Link') {
                $event->cta_link = "https://" . $event->cta_link;
            }
            if (!filter_var($event->category->photo, FILTER_VALIDATE_URL)) {
                $event->category->photo = $baseURL . '/' . $event->category->photo;
            }
            return $event;
        });

        $catagorys = Category::where('status', 'Active')->take(5)->get();
        $baseurl = request()->root();
        $catagorys->transform(function ($catagory) use ($baseurl) {
            $catagory->photo = $baseurl . '/' . $catagory->photo;
            return $catagory;
        });

        $data = [
            'contest' => $contests,
            'offers' => $offers,
            'events' => $events,
            'catagorys' => $catagorys
        ];

        return response()->json(responseData($data, "all data retrive sussessfully"));
    }

    public function platfrom()
    {
        $platfroms = Platform::where('status', 'Active')->get();
        $baseURL = request()->root();
        $platfroms->transform(function ($platfrom) use ($baseURL) {
            $platfrom->photo = $baseURL . '/' . $platfrom->photo;
            $platfrom->demo_details = "http://" . $platfrom->demo_details;
            return $platfrom;
        });
        return response()->json(responseData($platfroms, "Platfrom retrive Sucessfully"));
    }

    public function list_view($type)
    {
        $baseURL = request()->root();
        if ($type == "contest") {
            $data = Contest::with('platform', 'category')->where('status', 'Active')->paginate(10);
            $data->transform(function ($contest) use ($baseURL) {
                $contest->photo = $baseURL . '/' . $contest->photo;
                if ($contest->cta_type == 'Link') {
                    $contest->cta_link = "http://" . $contest->cta_link;
                }
                $contest->description = strip_tags($contest->description);
                if($contest->platform){
                    $contest->platform->photo = $baseURL . '/' . $contest->platform->photo;
                }
                $contest->category->photo = $baseURL . '/' . $contest->category->photo;
                return $contest;
            });
        } else if ($type == "offer") {
            $data = Offer::where('status', 'Active')->paginate(10);
            foreach ($data as $offer) {
                $offer->photo = $baseURL . '/' . $offer->photo;
                $offer->description = strip_tags($offer->description);
            }
        } else if ($type == "event") {
            $data = Event::with('category')->where('status', 'Active')->paginate(10);
            $data->transform(function ($event) use ($baseURL) {
                $event->photo = $baseURL . '/' . $event->photo;
                if ($event->cta_type == 'Link') {
                    $event->cta_link = "https://" . $event->cta_link;
                }
                $event->description = strip_tags($event->description);
                $event->category->photo = $baseURL . '/' . $event->category->photo;
                return $event;
            });
        }

        // $data = [
        //     'contest' => $contests ?? "",
        //     'offers' => $offers ?? "",
        //     'events' => $events ?? ""
        // ];

        return response()->json(responseData($data, "all data retrive sussessfully"));
    }

    public function list_category(Request $request)
    {
        $baseURL = request()->root();
        $id = $request->cat_id;
        $contests = Contest::with('platform', 'category')->where('category_id', $id)->paginate(5);
        $contests->transform(function ($contest) use ($baseURL) {
            $contest->photo = $baseURL . '/' . $contest->photo;
            if ($contest->cta_type == 'Link') {
                $contest->cta_link = "http://" . $contest->cta_link;
            }
            $contest->description = strip_tags($contest->description);
            $contest->platform->photo = $baseURL . '/' . $contest->platform->photo;
            $contest->category->photo = $baseURL . '/' . $contest->category->photo;
            return $contest;
        });

        $events = Event::with('category')->where('status', 'Active')->where('category_id', $id)->paginate(5);
        $events->transform(function ($event) use ($baseURL) {
            $event->photo = $baseURL . '/' . $event->photo;
            if ($event->cta_type == 'Link') {
                $event->cta_link = "https://" . $event->cta_link;
            }
            $event->description = strip_tags($event->description);
            $event->category->photo = $baseURL . '/' . $event->category->photo;
            return $event;
        });

        $data = [
            'contests' => $contests,
            'event' => $events,
        ];

        if ($data) {
            return response()->json(responseData($data, "all data retrive"));
        } else {
            return response()->json(responseData(null, "something went wrong", false));
        }
    }
}
