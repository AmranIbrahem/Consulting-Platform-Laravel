<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpertUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expert_users', function (Blueprint $table) {
            $table->id();
            $table->integer("expert_id");
            $table->integer("user_id");
            $table->string("day_date");
            $table->datetime("start_date");
            $table->datetime("end_date");
            $table->Integer("type");
            // $table->string("status")->default("pending");
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
        Schema::dropIfExists('expert_users');
    }
}