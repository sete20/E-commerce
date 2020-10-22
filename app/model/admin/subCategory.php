<?php

namespace App\model\admin;

use Illuminate\Database\Eloquent\Model;

class subCategory extends Model
{
    protected $table ='sub_categories';
    protected $fillable = [
        'category_id','subcategory_name'
    ];

}
