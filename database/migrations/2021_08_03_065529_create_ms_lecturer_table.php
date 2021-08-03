<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsLecturerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_lecturer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_reg');
            $table->string('name');
            $table->unsignedBigInteger('functional_position_id')->nullable();
            $table->foreign('functional_position_id')->references('id')->on('ms_functional_position')
                    ->onDelete('cascade')->onUpdate('cascade');
            $table->string('rank')->nullable();
            $table->string('last_education');
            $table->boolean('certification');
            $table->string('certification_year')->nullable();
            $table->unsignedBigInteger('major_id');
            $table->foreign('major_id')->references('id')->on('ms_major')
                    ->onDelete('cascade')->onUpdate('cascade');
            $table->string('avatar')->nullable();
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
        Schema::dropIfExists('ms_lecturer');
    }
}
