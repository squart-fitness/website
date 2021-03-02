<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGymFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gym_feedback', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('gym_id');
            $table->bigInteger('customer_id');
            $table->tinyInteger('rating_count')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('gym_feedback');
    }
}
