<?php

namespace App\Exports;

use App\Models\Review;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReviewexcelExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $all_ids = [];
    function __construct($all_ids) {
        $this->all_ids = $all_ids;
      }

    public function collection()
    {
        if(!empty($this->all_ids)){
            return Review::whereIn('id',$this->all_ids)->select("id", "type", "content","video","photo")->get();

        }else{
            return Review::select("id", "type", "content","video","photo")->get();
        }
       
    }
    public function headings(): array
    {
        return ["ID", "Type", "Content","Video","Photo"];
    }
}
