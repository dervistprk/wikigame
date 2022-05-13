<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevelopersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('developers', function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->longText('description');
            $table->bigInteger('games_count')->default(0);
            $table->tinyInteger('status')->default(1)->comment('0:pasif 1:aktif');
            $table->string('image')->default(null);
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
        Schema::dropIfExists('developers');
    }
}
