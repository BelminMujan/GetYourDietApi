<?php

use App\Models\DietStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDietStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diet_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('color');
            $table->timestamps();
        });

        $data =  array(
            [
                'title' => 'Requested',
                'color' => '#0d05f0',
            ],
            [
                'title' => 'Processing',
                'color' => '#08c27a',
            ],
            [
                'title' => 'Ready',
                'color' => '#6bc208',
            ],
            [
                'title' => 'Sent',
                'color' => '#05ed10',
            ],
        );
        foreach ($data as $item){
            $status = new DietStatus();
            $status->title =$item['title'];
            $status->color =$item['color'];
            $status->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diet_statuses');
    }
}
