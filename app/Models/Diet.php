<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diet extends Model
{
    use HasFactory;
    protected $table = 'diets';
    protected $fillable = ['diet_request_id', 'diet', 'pdf'];
    protected $casts = [
        'diet' => 'array'
    ];
}
