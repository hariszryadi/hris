<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrLeave extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_leave', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('start_date');
            $table->string('end_date');
            $table->integer('type_leave_id');
            $table->integer('category_leave_id');
            $table->integer('status');
            $table->integer('empl_id');
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
        Schema::dropIfExists('tr_leave');
    }
}
