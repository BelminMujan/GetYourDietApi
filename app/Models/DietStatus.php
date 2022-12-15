<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Model\DietRequest;

class DietStatus extends Model
{
    use HasFactory;
    protected $table = 'diet_statuses';

}
