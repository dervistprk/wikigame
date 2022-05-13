<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemRequirementsMinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_requirements_min', function(Blueprint $table){
            $table->id();
            $table->string('cpu');
            $table->string('gpu');
            $table->integer('ram');
            $table->tinyInteger('ram_unit');
            $table->integer('storage');
            $table->tinyInteger('storage_unit');
            $table->string('os');
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
        Schema::dropIfExists('system_requirements');
    }
}
