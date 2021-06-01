<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_role', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['permission_id', 'role_id']);
            $table->boolean('read_right')->nullable();
            $table->boolean('create_right')->nullable();
            $table->boolean('update_right')->nullable();
            $table->boolean('delete_right')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_role');
    }
}
