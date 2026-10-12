<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master_model;

class Master_data extends Controller
{
    protected $master_model;
    public function __construct()
    {
        $this->master_model = new Master_model();
    }

    public function index()
    {
        $data['master_list']=$this->master_model->get_master_data();
        return view('master_list',$data);
    }

    public function add_master_data()
    {
        $data['master_list']=$this->master_model->get_master_data();
        return view('add_master_data', $data);
    }

    public function master_insert(Request $request)
    {
        $type=$request->post('mast_type');
        $value=$request->post('mast_val');
        if($type =='' || $value =='') {
            return response()->json([
                "status"=>422,
                "message"=>"Please fill the required fields"
            ]);
        }
        else {
            $ins_array=array('type'=>$type,'value'=>$value,'delete_status'=>0);
            $mast_id=$this->master_model->insert_master_data($ins_array);

            return response()->json([
                "status"=>200, 
                "message"=>"Data addedd successfully"
            ]);
        }
    }
}
?>