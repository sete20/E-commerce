<?php

namespace App\model\admin;

use Illuminate\Database\Eloquent\Model;

class brand extends Model
{
    protected $table ='brands';
    protected $fillable = [
        'brand_name', 'brand_logo'
    ];
}
