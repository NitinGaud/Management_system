<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report_model;

class Dealer_data extends Controller
{
    protected $report_model;
    public function __construct()
    {
        $this->report_model = new Report_model();
    }

    public function index()
    {
        $data['dealer_list']=$this->report_model->get_dealer_details(['delete_status'=>0]);
        return view('dealer_list',$data);
    }

    public function add_dealer()
    {
        return view('add_dealer');
    }

    public function insert_dealer_data(Request $request)
    {
        $dealer_id=$request->post('dealer_id');
        $name=$request->post('name');
        $shop_name=$request->post('shop_name');
        $email_id=$request->post('email_id');
        $mobile_no=$request->post('mobile_no');
        $wa_mobile_no=$request->post('wa_mobile_no');
        $shop_address=$request->post('shop_address');

        $ins_array['name']=$name;
        $ins_array['shop_name']=$shop_name;
        $ins_array['email_id']=$email_id;
        $ins_array['mobile_no']=$mobile_no;
        $ins_array['wa_mobile_no']=$wa_mobile_no;
        $ins_array['shop_address']=$shop_address;
        $ins_array['delete_status']=0;

        if($dealer_id >0) {
            $result=$this->report_model->update_dealer($ins_array, ['id'=>$dealer_id]);
            if($result > 0) {
                return redirect()->route('dealer_details');
            } else {
                echo "Data Updation failed.";
            }

        } else {
            $ins_array['created_on']=date('Y-m-d H:i:s');
            $dealer_id=$this->report_model->insert_dealer($ins_array);
            if($dealer_id > 0) {
                return redirect()->route('dealer_details');
            } else {
                echo "insertion failed";
            }
        }
    }

    public function set_dealer_session(Request $request)
    {
        $dealer_id=$request->post('dealer_id');
        if (empty($dealer_id)) {
            return response()->json([
                'status' => 422,
                'message' => 'Dealer ID is required'
            ]);
        }
        session()->put('dealer_id', [
            'id' => $dealer_id,
            'expires_at' => now()->addMinutes(5)->timestamp
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Dealer ID stored successfully'
        ]);
    }

    public function edit_dealer()
    {
        $dealer_session = session()->get('dealer_id');
        if (!$dealer_session) {
            return redirect()->route('dealer_details');
        }

        if (now()->timestamp >= $dealer_session['expires_at']) {
            session()->forget('dealer_id');
            return redirect()->route('dealer_details');
        }

        $dealer_id=$dealer_session['id'];
        $data['dealer_id'] = $dealer_id;

        $data['dealer_detail'] = $this->report_model->get_dealer_data(['id'=>$dealer_id]);
        
        return view('add_dealer',$data);
    }

    public function delete_dealer(Request $request)
    {
        $dealer_id=$request->post('dealer_id');
        $update_array=['delete_status'=>1];
        $result=$this->report_model->update_dealer($update_array, ['id'=>$dealer_id]);
        if($result >0) {
            return response()->json([
                'status' => 200,
                'message' => 'Dealer Deleted Successfully.'
            ]);
        } else {
            return response()->json([
                'status' => 422,
                'message' => 'Dealer Deletion Failed.'
            ]);
        }


    }
}