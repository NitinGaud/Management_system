<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report_model extends Model
{
    public $timestamps = false;
    
    public function get_inventory($rep_type, $from_date, $to_date)
    {
        $model = new self();
        $model->setTable('inventory_data');

        $query = $model->newQuery();
        $query->join(
            'inventory_log',
            'inventory_log.inventory_id',
            '=',
            'inventory_data.id'
        );
        $query->select(
            'inventory_data.id',
            'inventory_data.brand',
            'inventory_data.category',
            'inventory_data.size',
            'inventory_data.name',
            'inventory_data.batch_no',
            'inventory_log.returned',
            'inventory_log.returned_date',
            'inventory_log.returned_amount',
            'inventory_log.sold',
            'inventory_log.sold_date',
            'inventory_log.sold_amount',
            'inventory_log.damaged',
            'inventory_log.damaged_date',
        );
        if($rep_type =='all') {
            $query->where(function ($q) use ($from_date, $to_date) {
                $q->whereBetween('inventory_log.returned_date', [
                    $from_date,
                    $to_date
                ])
                ->orWhereBetween('inventory_log.sold_date', [
                    $from_date,
                    $to_date
                ])
                ->orWhereBetween('inventory_log.damaged_date', [
                    $from_date,
                    $to_date
                ]);
            });
            $query->where(function ($q) {
                $q->where('inventory_log.returned', '>', 0)
                ->orWhere('inventory_log.sold', '>', 0)
                ->orWhere('inventory_log.damaged', '>', 0);
            });
        }
        else if($rep_type == 'sold') {
            $query->whereBetween('inventory_log.sold_date', [
                $from_date,
                $to_date
            ]);
            $query->where('inventory_log.sold', '>', 0);
        }
        else if($rep_type =='damaged') {
            $query->whereBetween('inventory_log.damaged_date', [
                $from_date,
                $to_date
            ]);
            $query->where('inventory_log.damaged', '>', 0);
        }
        else if($rep_type =='returned') {
            $query->whereBetween('inventory_log.returned_date', [
                $from_date,
                $to_date
            ]);
            $query->where('inventory_log.returned', '>', 0);
        }
        return $query->get();
    }

    public function insert_dealer($ins_array)
    {
        $model = new self();
        $model->setTable('dealer_data');
        foreach ($ins_array as $column => $value) {
            $model->{$column} = $value;
        }
        $model->save();
        return $model->id;
    }

    public function get_dealer_details($where =[])
    {
        $model = new self();
        $model->setTable('dealer_data');
        $query = $model->newQuery();
        foreach ($where as $column => $value) {
            $query->where($column, $value);
        }
        $query->select('*');
        return $query->get();
    }

    public function get_dealer_data($where =[])
    {
        $model = new self();
        $model->setTable('dealer_data');
        $query = $model->newQuery();
        foreach ($where as $column => $value) {
            $query->where($column, $value);
        }
        $query->select('*');
        return $query->first();
    }

    public function update_dealer($update_data=[], $where=[])
    {
        $model = new self();
        $model->setTable('dealer_data');
        $query = $model->newQuery();
        foreach ($where as $column => $value) {
            $query->where($column, $value);
        }
        // dd($query->toSql(), $query->getBindings());
        return $query->update($update_data);
    }
}