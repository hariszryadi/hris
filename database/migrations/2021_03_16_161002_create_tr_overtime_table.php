<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrOvertimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_overtime', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tr_overtime_id')->nullable();
            $table->string('overtime_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->time('duration');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('empl_id');
            $table->foreign('empl_id')->references('id')->on('ms_empl')
                    ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('status');
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
        Schema::dropIfExists('tr_overtime');
    }
}
