<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->double('calories', 5, 2);
            $table->double('carbs', 5, 2)->default(0);
            $table->double('fats', 5, 2)->default(0);
            $table->double('proteins', 5, 2)->default(0);
            $table->string('food_category')->nullable();
            $table->string('macro_category')->nullable();
            $table->string('diseases')->nullable();
            $table->string('allergies')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food');
    }
}
