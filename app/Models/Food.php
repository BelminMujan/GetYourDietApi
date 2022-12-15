<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FoodCategory;

class Food extends Model
{
    use HasFactory;
    protected $table = 'food';
    protected $fillable = ['title', 'calories', 'carbs', 'fats', 'proteins', 'food_category'];

    public function foodCategory(){
        return $this->belongsTo(FoodCategory::class, 'food_category');
    }
}
