<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table ='courses';
    protected $fillable =[
        'id',
        'name',
        'summary',
        //'price',
        'image',
        'discount',
        //'duration',
        'Grade',
        'status',
        'detail',
        'created_at',
        'updated_at',
        'course_cate_id'
    ];
    use HasFactory;
}
