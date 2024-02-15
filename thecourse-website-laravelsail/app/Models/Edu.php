<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edu extends Model
{
    use HasFactory;
    protected $table = 'edus';
    protected $fillable = [
        'id',
        'name',
        'status',
        'created_at',
        'updated_at'
    ];
}
