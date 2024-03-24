<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 255);
            $table->string('email', 100)->unique();
            $table->string('phone', 20)->nullable()->unique();
            $table->char('gender', 1)->nullable();
            $table->char('password')->nullable();
            $table->uuid('staff_id')->nullable();
            $table->boolean('is_active')->default(1);
            $table->dateTime('created_at')->nullable()->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->dateTime('updated_at')->nullable()->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->dateTime('deleted_at')->nullable();
            $table->uuid('app_id');
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
        Schema::dropIfExists('staffs');
    }
}
