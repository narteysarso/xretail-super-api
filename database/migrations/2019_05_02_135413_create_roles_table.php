<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->uuid('staff_id')->nullable();
            $table->uuid('app_id')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->foreign("staff_id")->references("id")->on("staffs")->onDelete("cascade");
            $table->foreign("app_id")->references("id")->on("apps")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
