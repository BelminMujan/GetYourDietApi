<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Food;

class FoodController extends Controller {

    public function getAllFood(){
        $data = Food::with('foodCategory')->get();
        return response()->json([
            'food' => $data
        ], 200);
    }

    public function updateFood(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string',
            'calories' => 'required',
            'carbs' => 'required',
            'fats' => 'required',
            'proteins' => 'required',
            'food_category' => 'required',
        ]);
        $id = $request->get('id');
        $food = Food::find($id);
        $food->fill($validated)->save();
        return response()->json([
            'message' => $validated['title'].' updated successfully!'
        ], 200);
    }

    public function deleteFood(Request $request){
        Food::destroy(request()->id);
        return response()->json([
            'message' => 'Food is deleted successfully!'
        ], 200);
    }
}