<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('user_name')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('surname');
            $table->timestamp('birth_day')->default(Carbon::now());
            $table->string('gender')->nullable();
            $table->text('about')->nullable();
            $table->boolean('is_admin')->default(0);
            $table->integer('comment_count')->default(0);
            $table->boolean('is_email_verified')->default(0);
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('github_id')->nullable();
            $table->string('linkedin_id')->nullable();
            $table->string('remember_token')->nullable();
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
        Schema::dropIfExists('users');
    }
}
