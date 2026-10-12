<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dashboard_model;

class Dashboard extends Controller
{
    protected $dashboard_model;
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->dashboard_model = new Dashboard_model();
    }
    public function index()
    {
        $data['sold_by_brand'] = $this->dashboard_model->get_sold_by_brand();
        return view('dashboard',$data);
    }
}
?>