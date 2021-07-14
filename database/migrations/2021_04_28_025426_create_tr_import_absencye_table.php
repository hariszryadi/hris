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
            $table->string('code_fingerprint');
            $table->string('empl_name');
            $table->string('absencye_date');
            $table->time('time_entry');
            $table->time('time_return');
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
