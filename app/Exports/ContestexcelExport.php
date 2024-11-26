<?php

namespace App\Exports;

use App\Models\Contest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContestexcelExport implements FromCollection, WithHeadings
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
            return Contest::whereIn('id',$this->all_ids)->select("id", "name", "status")->get();

        }else{
            return Contest::select("id", "name", "status")->get();
        }
       
    }
    public function headings(): array
    {
        return ["ID", "Name", "Status"];
    }
}
