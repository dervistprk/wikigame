<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemRequirementsRecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_requirements_rec', function(Blueprint $table){
            $table->id();
            $table->string('cpu_rec');
            $table->string('gpu_rec');
            $table->integer('ram_rec');
            $table->boolean('ram_rec_unit');
            $table->integer('storage_rec');
            $table->boolean('storage_rec_unit');
            $table->string('os_rec');
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
        Schema::dropIfExists('system_requirements_rec');
    }
}
