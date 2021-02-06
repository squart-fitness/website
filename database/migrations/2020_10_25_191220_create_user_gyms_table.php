<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserGymsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_gym', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('gym_id');
            $table->string('gym_name');
            $table->string('gym_phone');
            $table->string('gym_email');
            $table->string('personal_adhaar');
            $table->string('adhaar_front');
            $table->string('adhaar_back');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_deleted')->default(1);
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
        Schema::dropIfExists('user_gyms');
    }
}
