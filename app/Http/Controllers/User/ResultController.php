<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use Google\Service\Sheets\Sheet;
use Illuminate\Http\Request;
use Revolution\Google\Sheets\Facades\Sheets;
use Illuminate\Support\Facades\Validator;

class ResultController extends Controller
{
    public function getGoogleSheetValue(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contest_id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors();
            return response()->json(responseData(null, $message, false));
        }
        $data = Contest::where('id', $request->contest_id)->first();
        // $rows = Sheets::sheet('Sheet 1')->get();
        // $header = $rows->pull(0);
        // $values = Sheets::collection(header: $header, rows: $rows);

        // Assuming you want to return the values
        //return $values->toArray();

        $result_link = $data->result_link;

        if ($result_link != null) {
            $values = Sheets::spreadsheet('1YP9GrTX8jREegwNH7A2tSV4vZrNWF50oWos4nrx-HXs')->sheet($result_link)->get();
            return response()->json(responseData($values, 'data retrive'));
        } else {
            return response()->json(responseData(null, 'no result available', false));
        }
    }
}
