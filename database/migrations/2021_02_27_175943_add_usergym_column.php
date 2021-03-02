<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsergymColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_gym', function (Blueprint $table) {
            $table->string('gym_phone_second')->after('gym_phone')->nullable();
            $table->string('state')->after('gym_logo');
            $table->string('city')->after('state');
            $table->string('pincode')->after('city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_gym', function (Blueprint $table) {
            $table->dropColumn(['gym_phone_second']);
        });
    }
}
