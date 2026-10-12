<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory_model;

class Inventory extends Controller
{
    protected $inventory_model;
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->inventory_model = new Inventory_model();
    }

    public function index()
    {
        session()->forget('inventory_id');
        $data['inventory_list']=$this->inventory_model->get_inventory_values(['delete_status'=>0]);
        return view('inventory_list',$data);
    }

    public function add_inventory()
    {
        $data['brand_list']=$this->inventory_model->get_master_values(['type'=>'Brand']);
        $data['category_list']=$this->inventory_model->get_master_values(['type'=>"Category"]);
        $data['size_list']=$this->inventory_model->get_master_values(['type'=>"Size"]);
        return view('add_inventory',$data);
    }

    public function inventory_insert(Request $request)
    {
        $brand=$request->post('brand');
        $category=$request->post('category');
        $size=$request->post('size');
        $name=$request->post('name');
        $quantity=$request->post('quantity');
        $batch_no=$request->post('batch_no');
        $amount=$request->post('amount');
        if(!$amount) {
            $amount=0;
        }
        $purch_date=$request->post('purch_date');


        if ($request->hasFile('img_file')) {
            $image = $request->file('img_file');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(
                public_path('inventory'),
                $imageName );
            $inventory_data['old_img_name'] = $image->getClientOriginalName();
            $inventory_data['new_img_name'] = $imageName;
        }
        $inventory_data['brand']=$brand;
        $inventory_data['category']=$category;
        $inventory_data['size']=$size;
        $inventory_data['name']=$name;
        $inventory_data['quantity']=$quantity;
        $inventory_data['batch_no']=$batch_no;
        $inventory_data['amount']=$amount;
        $inventory_data['purch_date']=$purch_date;
        $inventory_data['delete_status']=0;
        $inventory_data['created_on']=date('Y-m-d H:i:s');
        $inventory_id=$this->inventory_model->insert_inventory_data($inventory_data);

        if($inventory_id > 0) {
            session()->forget('inventory_id');
            return redirect()->route('inventory_list');
        } else {
            echo "insertion failed";
        }

    }

    public function set_inventory_session(Request $request)
    {
        $inventory_id=$request->post('inventory_id');
        if (empty($inventory_id)) {
            return response()->json([
                'status' => 422,
                'message' => 'Inventory ID is required'
            ]);
        }
        session()->put('inventory_id', [
            'id' => $inventory_id,
            'expires_at' => now()->addMinutes(5)->timestamp
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Inventory ID stored successfully'
        ]);
    }

    public function update_inventory()
    {
        $inventory_session = session()->get('inventory_id');
        if (!$inventory_session) {
            return redirect()->route('inventory_list');
        }

        if (now()->timestamp >= $inventory_session['expires_at']) {
            session()->forget('inventory_id');
            return redirect()->route('inventory_list');
        }

        $inventory_id=$inventory_session['id'];
        $data['inventory_id'] = $inventory_id;
        $data['inventory'] = $this->inventory_model->get_inventory(['id' => $inventory_id]);
        $data['quantity'] = $this->inventory_model->get_remaining_quantity($inventory_id);
        return view('update_inventory',$data);
    }

    public function delete_inventory_image(Request $request)
    {
        $inventory_id=$request->post('inventory_id');
        $new_img_name=$request->post('new_img_name');

        $update_array=['old_img_name'=>"",'new_img_name'=>""];
        $result=$this->inventory_model->update_inventory($update_array,['id'=>$inventory_id]);
        if($result >0) {
            $imagePath = public_path('inventory/' . $new_img_name);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Image Deleted Successfully'
            ]);
        } else {
            return response()->json([
                'status' => 422,
                'message' => 'Image Deletion Failed'
            ]);
        }
    }

    public function delete_inventory(Request $request)
    {
        $inventory_id=$request->post('inventory_id');
        $update_array=['delete_status'=>1,'updated_on'=>date('Y-m-d H:i:s')];
        $result=$this->inventory_model->update_inventory($update_array,['id'=>$inventory_id]);
        if($result >0) {
            return response()->json([
                'status' => 200,
                'message' => 'Inventory Deleted Successfully'
            ]);
        } else {
            return response()->json([
                'status' => 422,
                'message' => 'Inventory Deletion Failed'
            ]);
        }
    }

    public function log_list()
    {
        $inventory_session = session()->get('inventory_id');
        if (!$inventory_session) {
            return redirect()->route('inventory_list');
        }

        if (now()->timestamp >= $inventory_session['expires_at']) {
            session()->forget('inventory_id');
            return redirect()->route('inventory_list');
        }
        $inventory_id=$inventory_session['id'];
        $data['inventory_id'] = $inventory_id;
        $data['inventory'] = $this->inventory_model->get_inventory(['id' => $inventory_id]);
        $data['inventory_log'] = $this->inventory_model->get_inventory_log(['inventory_id' => $inventory_id]);
        $data['quantity'] = $this->inventory_model->get_remaining_quantity($inventory_id);

        return view('log_list',$data);   
    }

    public function update_inventory_data(Request $request)
    {
        $inventory_id=$request->post('inventory_id');
        $sold = $request->post('sold') ?: 0;
        $sold_date=$request->post('sold_date');
        $sold_amount = $request->post('sold_amount') ?: 0;
        
        $returned = $request->post('returned') ?: 0;
        $return_date=$request->post('return_date');
        $return_amount = $request->post('return_amount') ?: 0;
        
        $damaged = $request->post('damaged') ?: 0;
        $damaged_date=$request->post('damaged_date');

        $log_data['inventory_id']=$inventory_id;
        $log_data['sold']=$sold;
        $log_data['sold_date']=$sold_date;
        $log_data['sold_amount']=$sold_amount;
        $log_data['returned']=$returned;
        $log_data['returned_date']=$return_date;
        $log_data['returned_amount']=$return_amount;
        $log_data['damaged']=$damaged;
        $log_data['damaged_date']=$damaged_date;
        $log_data['created_on']=date('Y-m-d H:i:s');
        $log_id=$this->inventory_model->insert_inventory_log($log_data);
        
        if($log_id > 0) {
            session()->forget('inventory_id');
            return redirect()->route('inventory_list');
        } else {
            echo "insertion failed";
        }

    }
}
?>