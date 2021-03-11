<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsCategoryLeave extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_category_leave', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category_leave');
            $table->unsignedBigInteger('type_leave_id');
            $table->foreign('type_leave_id')->references('id')->on('ms_type_leave')
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
        Schema::dropIfExists('ms_category_leave');
    }
}
