<?php

namespace App\Exports;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserexcelExport implements FromCollection
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
            return User::whereIn('id',$this->all_ids)->select("id", "name", "email","type")->get();

        }else{
            return User::select("id", "name", "email","type")->get();
        }

    }
    public function headings(): array
    {
        return ["ID", "Name", "Email", "Type"];
    }

}