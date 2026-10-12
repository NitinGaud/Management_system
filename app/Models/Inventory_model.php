<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory_model extends Model
{
    public $timestamps = false;

    public function get_master_values($where =[])
    {
        $model = new self();
        $model->setTable('master_data');
        $query = $model->newQuery();
        foreach ($where as $column => $value) {
            $query->where($column, $value);
        }
        $query->where('delete_status', 0);
        $query->select('type', 'value');
        return $query->get();
    }

    public function insert_inventory_data($ins_array)
    {
        $model = new self();
        $model->setTable('inventory_data');
        foreach ($ins_array as $column => $value) {
            $model->{$column} = $value;
        }
        $model->save();
        return $model->id;
    }

    public function get_inventory_values($where =[])
    {
        $model = new self();
        $model->setTable('inventory_data');
        $query = $model->newQuery();
        foreach ($where as $column => $value) {
            $query->where($column, $value);
        }
        $query->select('*');
        return $query->get();
    }

    public function get_inventory($where =[])
    {
        $model = new self();
        $model->setTable('inventory_data');
        $query = $model->newQuery();
        foreach ($where as $column => $value) {
            $query->where($column, $value);
        }
        $query->select('*');
        return $query->first();
    }

    public function update_inventory($update_data=[], $where=[])
    {
        $model = new self();
        $model->setTable('inventory_data');
        $query = $model->newQuery();
        foreach ($where as $column => $value) {
            $query->where($column, $value);
        }
        // dd($query->toSql(), $query->getBindings());
        return $query->update($update_data);
    }

    public function insert_inventory_log($ins_array)
    {
        $model = new self();
        $model->setTable('inventory_log');
        foreach ($ins_array as $column => $value) {
            $model->{$column} = $value;
        }
        $model->save();
        return $model->id;
    }
    

    public function get_inventory_log($where =[])
    {
        $model = new self();
        $model->setTable('inventory_log');
        $query = $model->newQuery();
        foreach ($where as $column => $value) {
            $query->where($column, $value);
        }
        $query->select('*');
        $query->orderBy('created_on', 'DESC');
        return $query->get();
    }

    public function get_remaining_quantity($inventory_id)
    {
        $model = new self();
        $model->setTable('inventory_data');
        $query = $model->newQuery();
        $query->leftJoin(
            'inventory_log',
            'inventory_log.inventory_id',
            '=',
            'inventory_data.id'
        );

        $query->where('inventory_data.id', $inventory_id);
        $query->select(
            'inventory_data.id',
            'inventory_data.quantity'
        );
        $query->selectRaw('
            COALESCE(SUM(inventory_log.sold), 0) AS total_sold
        ');

        $query->selectRaw('
            COALESCE(SUM(inventory_log.damaged), 0) AS total_damaged
        ');

        $query->selectRaw('
            COALESCE(SUM(inventory_log.returned), 0) AS total_returned
        ');

        $query->selectRaw('
            (
                inventory_data.quantity
                -
                (
                    COALESCE(SUM(inventory_log.sold), 0)
                    + COALESCE(SUM(inventory_log.damaged), 0)
                    - COALESCE(SUM(inventory_log.returned), 0)
                )
            ) AS remaining_quantity
        ');

        $query->groupBy(
            'inventory_data.id',
            'inventory_data.quantity'
        );
        $result = $query->first();
        return $result;
    }
}
