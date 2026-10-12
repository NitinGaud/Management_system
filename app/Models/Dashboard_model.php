<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dashboard_model extends Model
{
    public $timestamps = false;
    
    public function get_sold_by_brand()
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

        $query->select('inventory_data.brand');
        $query->selectRaw('COALESCE(SUM(inventory_log.sold), 0) AS total_sold');
        $query->groupBy('inventory_data.brand');
        $query->orderByDesc('total_sold');
        $query->limit(5);

        return $query->get();
    }

}