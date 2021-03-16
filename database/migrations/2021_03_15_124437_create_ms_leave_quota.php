<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsLeaveQuota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_leave_quota', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('used_quota');
            $table->integer('max_quota');
            $table->unsignedBigInteger('empl_id');
            $table->foreign('empl_id')->references('id')->on('ms_empl')
                    ->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('ms_leave_quota');
    }
}
