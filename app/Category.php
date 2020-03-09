<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Category extends Model
{
    //
    use softDeletes;

    protected $primaryKey = 'categories_id';
    //public $timestamps=false;

    protected $fillable = ['id', 'category_name', 'total', 'available', 'image_name'];
}
