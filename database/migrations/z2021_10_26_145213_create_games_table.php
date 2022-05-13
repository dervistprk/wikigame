<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('developer_id')->nullable();
            $table->unsignedBigInteger('publisher_id')->nullable();
            $table->unsignedBigInteger('sys_req_min_id')->nullable();
            $table->unsignedBigInteger('sys_req_rec_id')->nullable();
            $table->unsignedBigInteger('game_details_id')->nullable();
            $table->string('slug');
            $table->text('sub_title');
            $table->longText('description');
            $table->tinyInteger('status')->default(1)->comment('0:pasif 1:aktif');
            $table->bigInteger('hit')->default(0);
            $table->string('cover_image');
            $table->string('image1');
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('image4')->nullable();
            $table->string('image5')->nullable();
            $table->string('image6')->nullable();
            $table->string('image7')->nullable();
            $table->string('video1');
            $table->string('video2')->nullable();
            $table->string('video3')->nullable();
            $table->string('video4')->nullable();
            $table->string('video5')->nullable();
            $table->timestamps();
        });

        Schema::table('games', function(Blueprint $table){
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('developer_id')->references('id')->on('developers')->onDelete('cascade');
            $table->foreign('publisher_id')->references('id')->on('publishers')->onDelete('cascade');
            $table->foreign('sys_req_min_id')->references('id')->on('system_requirements_min');
            $table->foreign('sys_req_rec_id')->references('id')->on('system_requirements_rec');
            $table->foreign('game_details_id')->references('id')->on('game_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
