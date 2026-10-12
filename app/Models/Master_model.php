<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Master_model extends Model
{
    public $timestamps = false;

    public function insert_master_data($ins_array) {
        $model = new self();
        $model->setTable('master_data');
        foreach ($ins_array as $column => $value) {
            $model->{$column} = $value;
        }
        $model->save();
        return $model->id;
    }

    public function get_master_data()
    {
        $model = new self();
        $model->setTable('master_data');
        return $model->select('type','value')
            ->where('delete_status', 0)
            ->get();
    }
}
