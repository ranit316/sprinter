<?php

namespace App\Exports;
use App\Models\Platform;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PlatformexcelExport implements FromCollection
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
            return Platform::whereIn('id',$this->all_ids)->select("id", "name", "demo_user_id","demo_password","demo_details","status")->get();

        }else{
            return Platform::select("id", "name", "demo_user_id","demo_password","demo_details","status")->get();
        }

    }
    public function headings(): array
    {
        return ["ID", "Name", "Demo User Id", "Demo Password","Demo Website Link","Status"];
    }
}
