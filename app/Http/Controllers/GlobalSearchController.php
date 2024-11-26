<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;



class GlobalSearchController extends Controller
{
   
    public    $search_data = array();
    public $search_query;

     

    protected $all_table = ['platforms', 'offers','categories','contests','events','faqs','faq_categories','reviews','customers'];
    protected $all_route = ['platforms' => 'platforms.show', 'offers' => 'offers.show'
,'categories' => 'categories.show'
,'contests' => 'contests.show'
,'events' => 'events.show'
,'faqs' => 'faqs.show'
,'faq_categories' => 'faq_categories.show'
,'reviews' => 'reviews.show'
,'customers' => 'customers.show'
];
    protected $show_column = ['platforms' => ['name'], 'offers' => ['name']
    , 'categories' => ['name']
    , 'contests' => ['name']
    , 'events' => ['name']
    , 'faqs' => ['name']
    , 'faq_categories' => ['name']
    , 'reviews' => ['content']
    , 'customers' => ['first_name']];
    protected $lable = ['platforms' => 'Platform','offers'=>'Offer'
    ,'categories'=>'Category'
    ,'contests'=>'Contest'
    ,'events'=>'Event'
    ,'faqs'=>'FAQ'
    ,'faq_categories'=>'FAQ Category'
    ,'reviews'=>'Review'
    ,'customers' => 'Customer'];

    public function index(Request $request, $search)
    {
       
        // here i have assingin the search query data into the instance variable
        $this->search_query = $search;


        // getting the all table from the database
        // $tables = DB::select('SHOW TABLES');
        // foreach ($tables as $table) {
        //     $table = array_values((array)$table)[0];
        //     self::search($table, self::getColumn($table));
        // }
        if (strlen($this->search_query) > 0) {
            foreach ($this->all_table as $table) {
                self::search($table, self::getColumn($table));
            }
        }
        return view('global_search_index', ['datas' => $this->search_data, 'all_route' => $this->all_route, 'show_column' => $this->show_column, 'lable' => $this->lable]);
  
   }
    // getting the column name of the particular  table 
    private static function getColumn(string $table)
    {
        return Schema::getColumnListing($table);
    }

    // doing the sarch operation here 
    public  function search(string $table, array $columns)
    {
        $table_data =   DB::table($table);
        if (count($table_data->get()) > 0) {
            foreach ($columns as $column) {
                $table_data = $table_data->orWhere($column, 'LIKE', '%' . $this->search_query . '%');
            }
            $table_data = $table_data->limit(20)->get();
            if (count($table_data) > 0) {
                $final_data['table'] = $table;
                $final_data['data'] = $table_data;
                array_push($this->search_data, $final_data);
            }
        }
    }
}
