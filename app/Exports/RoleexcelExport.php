<?php

namespace App\Exports;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class RoleexcelExport implements FromCollection
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
            return Role::whereIn('id',$this->all_ids)->select("id", "name")->get();
        }else{
            return Role::select("id", "name")->get();
        }

    }
    public function headings(): array
    {
        return ["ID", "Name"];
    }
}
