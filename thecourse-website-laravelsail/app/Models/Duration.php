<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duration extends Model
{
    protected $table = 'courses_durations';
    protected $fillable = [
        'id',
        'duration',
        'price',
        'created_at',
        'updated_at',
        'course_id'
    ];
    use HasFactory;
}
