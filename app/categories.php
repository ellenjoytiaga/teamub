<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{

    use SoftDeletes;

    protected $dates=['deleted_at'];

    protected $fillable = [
        'id',
        'category_name',
        'category_desc'
             
    ];
}
class category extends Model
{
    protected $fillable = [
        'id',
        'category_name',
        'category_desc'
             
    ];
}

