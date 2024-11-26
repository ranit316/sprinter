<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Type;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function category()
    {
        $data = Category::where('status', 'Active')->get();
        if ($data) {
            return response()->json(responseData($data, "data retrive successful"));
        } else {
            return response()->json(responseData(null, "something went erong", false));
        }
    }

    public function type()
    {
        $data = Type::where('status', 'active')->get();
        if ($data) {
            return response()->json(responseData($data, "data retrive successful"));
        } else {
            return response()->json(responseData(null, "something went erong", false));
        }
    }

    public function faq(Request $request)
    {
        $data = Faq::with('category')->where('type_id', $request->type_id)->orderBy('category_id')->get();

        // Group FAQs by category
        $groupedData = [];
        foreach ($data as $faq) {
            $categoryName = $faq->category->name;
            if (!isset($groupedData[$categoryName])) {
                $groupedData[$categoryName] = [
                    'category_id' => $faq->category_id,
                    'category_name' => $categoryName,
                    'faqs' => [],
                ];
            }

            // Strip HTML tags from the description
            $faq->description = strip_tags($faq->description);

            // Add FAQ to the category's FAQs
            $groupedData[$categoryName]['faqs'][] = $faq;
        }

        $groupedData = array_values($groupedData);

        if ($groupedData) {
            return response()->json(responseData($groupedData, "data retrieve successful"));
        } else {
            return response()->json(responseData(null, "something went wrong", false));
        }
    }
}
