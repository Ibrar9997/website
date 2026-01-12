<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Category extends Model

{
    protected $fillable = [
        'category_name',
        'slug',
        'added_date',
        'status'
    ];
}

