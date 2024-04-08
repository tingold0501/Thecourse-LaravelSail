<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table ="students";
    protected $fillabale = [
        'id',
        'name',
        'password',
        'email',
        'phone',
        'status',
        'remember_token',
        'created_at',
        'updated_at'
    ];
}
