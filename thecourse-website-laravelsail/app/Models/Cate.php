<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    use HasFactory;
    protected $table = 'course_cates';
    protected $fillable =[
        'id',
        'name',
        'created_at',
        'updated_at',
        'edu_id'
    ];
}
