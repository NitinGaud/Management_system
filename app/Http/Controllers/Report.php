<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report_model;

class Report extends Controller
{
    protected $report_model;
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->report_model = new Report_model();
    }

    public function index()
    {
        return view('inventory_report');
    }

    public function generate_report(Request $request)
    {
        $from_date=$request->post('from_date');
        $to_date=$request->post('to_date');
        $rep_type=$request->post('rep_type');

        if($rep_type =='all') {
            $fileName = 'all_inventory_' . date('Ymd_His') . '.csv';
            $headers = [ 
                'Content-Type' => 'text/csv', 
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"', 
            ];
            $all_inventory=$this->report_model->get_inventory($rep_type, $from_date, $to_date);
            $callback = function () use ($all_inventory) { 
                $file = fopen('php://output', 'w');
                fputcsv($file, [ 'Brand', 'Category', 'Size', 'Name', 'Batch No', 'Sold Quantity', 'Sold Date', 'Sold Amount', 
                'Returned', 'Returned Quantity', 'Returned Amount', 'Damaged', 'Damaged Quantity' ]);
                foreach ($all_inventory as $row) { 
                    fputcsv($file, [ 
                        $row->brand, 
                        $row->category, 
                        $row->size, 
                        $row->name, 
                        $row->batch_no, 
                        $row->sold, 
                        $row->sold_date,
                        $row->sold_amount,
                        $row->returned, 
                        $row->returned_date,
                        $row->returned_amount,
                        $row->damaged, 
                        $row->damaged_date
                    ]);
                }
                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        }
        else if($rep_type =='sold') {
            $fileName = 'sold_inventory_' . date('Ymd_His') . '.csv';
            $headers = [ 
                'Content-Type' => 'text/csv', 
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"', 
            ];
            $sold_inventory=$this->report_model->get_inventory($rep_type, $from_date, $to_date);
            $callback = function () use ($sold_inventory) { 
                $file = fopen('php://output', 'w');
                fputcsv($file, [ 'Brand', 'Category', 'Size', 'Name', 'Batch No', 'Sold Quantity', 'Sold Date', 'Sold Amount']);
                foreach ($sold_inventory as $row) { 
                    fputcsv($file, [ 
                        $row->brand, 
                        $row->category, 
                        $row->size, 
                        $row->name, 
                        $row->batch_no, 
                        $row->sold, 
                        $row->sold_date,
                        $row->sold_amount
                    ]);
                }
                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        }
        else if($rep_type =='damaged') {
            $fileName = 'damaged_inventory_' . date('Ymd_His') . '.csv';
            $headers = [ 
                'Content-Type' => 'text/csv', 
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"', 
            ];
            $damaged_inventory=$this->report_model->get_inventory($rep_type, $from_date, $to_date);
            $callback = function () use ($damaged_inventory) { 
                $file = fopen('php://output', 'w');
                fputcsv($file, [ 'Brand', 'Category', 'Size', 'Name', 'Batch No', 'Damaged Quantity', 'Damaged Date']);
                foreach ($damaged_inventory as $row) { 
                    fputcsv($file, [ 
                        $row->brand, 
                        $row->category, 
                        $row->size, 
                        $row->name, 
                        $row->batch_no, 
                        $row->damaged, 
                        $row->damaged_date
                    ]);
                }
                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        }
        else if($rep_type =='returned') {
            $fileName = 'returned_inventory_' . date('Ymd_His') . '.csv';
            $headers = [ 
                'Content-Type' => 'text/csv', 
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"', 
            ];
            $returned_inventory=$this->report_model->get_inventory($rep_type, $from_date, $to_date);
            $callback = function () use ($returned_inventory) { 
                $file = fopen('php://output', 'w');
                fputcsv($file, [ 'Brand', 'Category', 'Size', 'Name', 'Batch No', 'Returned Quantity', 'Returned Date', 'Returned Amount']);
                foreach ($returned_inventory as $row) { 
                    fputcsv($file, [ 
                        $row->brand, 
                        $row->category, 
                        $row->size, 
                        $row->name, 
                        $row->batch_no, 
                        $row->returned, 
                        $row->returned_date,
                        $row->returned_amount
                    ]);
                }
                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        }
    }
}