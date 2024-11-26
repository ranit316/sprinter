<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerexcelExport implements FromCollection, WithHeadings
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
            return Customer::whereIn('id',$this->all_ids)->select("id", "first_name", "last_name","address","phone_number")->get();

        }else{
            return Customer::select("id", "first_name", "last_name","address","phone_number")->get();
        }
       
    }
    public function headings(): array
    {
        return ["ID", "First Name", "Last Name","Address","Phone Number"];
    }
}
