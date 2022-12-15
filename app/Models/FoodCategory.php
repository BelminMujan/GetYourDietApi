<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Food;

class FoodCategory extends Model
{
    use HasFactory;
    protected $table = 'food_categories';
    public function food()
    {
        return $this->hasMany(Food::class);
    }
}
