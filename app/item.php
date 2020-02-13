<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{

	use SoftDeletes;

    protected$dates=['deleted_at'];

    protected $fillable = [
        'id',
        'item_name',
        'category_name',
        'item_desc',
        'item_qty',
        'item_status'
   
    ];
}
