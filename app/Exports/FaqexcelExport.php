<?php

namespace App\Exports;

use App\Models\Faq;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FaqexcelExport implements FromCollection, WithHeadings
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
            return Faq::whereIn('id',$this->all_ids)->select("id", "name", "status")->get();

        }else{
            return Faq::select("id", "name", "status")->get();
        }
       
    }
    public function headings(): array
    {
        return ["ID", "Name", "Status"];
    }
}
