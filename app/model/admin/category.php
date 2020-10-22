<?php

namespace App\model\admin;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $table ='categories';
    protected $fillable = [
        'category_name'
    ];
}
