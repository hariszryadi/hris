<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrOvertimeAmountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_overtime_amount', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('overtime_id');
            $table->foreign('overtime_id')->references('id')->on('tr_overtime')
                    ->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('empl_id');
            $table->foreign('empl_id')->references('id')->on('ms_empl')
                    ->onDelete('cascade')->onUpdate('cascade');
            $table->string('duration');
            $table->string('total_amount');
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
        Schema::dropIfExists('tr_overtime_amount');
    }
}
