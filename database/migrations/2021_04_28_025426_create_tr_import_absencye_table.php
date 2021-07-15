<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrImportAbsencyeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_import_absencye', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_finger');
            $table->string('empl_name');
            $table->string('absencye_date');
            $table->string('time_entry')->nullable();
            $table->string('time_return')->nullable();
            $table->string('user');
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
        Schema::dropIfExists('tr_import_absencye');
    }
}
