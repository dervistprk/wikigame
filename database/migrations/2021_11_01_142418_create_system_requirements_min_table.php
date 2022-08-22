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
            $table->string('cpu_min');
            $table->string('gpu_min');
            $table->integer('ram_min');
            $table->boolean('ram_min_unit');
            $table->integer('storage_min');
            $table->boolean('storage_min_unit');
            $table->string('os_min');
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
        Schema::dropIfExists('system_requirements_min');
    }
}
