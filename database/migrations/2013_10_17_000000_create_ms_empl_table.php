<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsEmplTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_empl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nip')->unique();
            $table->string('empl_name');
            $table->string('birth_date');
            $table->text('address');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('gender');
            $table->string('religion');
            $table->unsignedBigInteger('division_id');
            $table->foreign('division_id')->references('id')->on('ms_division')
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
        Schema::dropIfExists('ms_empl');
    }
}
