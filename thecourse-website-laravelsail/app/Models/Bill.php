<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table ='bills';
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'status',
        'created_at',
        'updated_at',
        'classe_id',
        'courses_duration_id'
    ];
    use HasFactory;
}
