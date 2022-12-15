<?php

use App\Models\FoodCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });
        $data =  array(
            [
                'title' => 'Fruit',
            ],
            [
                'title' => 'Vegetables',
            ],
            [
                'title' => 'Meat,Eggs and Milk',
            ],
            [
                'title' => 'Grains',
            ],
            [
                'title' => 'Nuts',
            ],
        );
        foreach ($data as $item){
            $category = new FoodCategory();
            $category->title =$item['title'];
            $category->save();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_categories');
    }
}
