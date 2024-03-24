<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRoleStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_staff', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('role_id');
            $table->uuid('staff_id');
            $table->dateTime('created_at')->nullable()->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->dateTime('updated_at')->nullable()->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->uuid('app_id');
            $table->foreign("role_id")->references("id")->on("roles")->onDelete("cascade");
            $table->foreign("staff_id")->references("id")->on("staffs")->onDelete("cascade");
            $table->foreign("app_id")->references("id")->on("apps")->onDelete("cascade");
        });

        DB::unprepared("
			DROP TRIGGER IF EXISTS `BEFORE_ROLE_STAFF_INSERT`;CREATE TRIGGER `BEFORE_ROLE_STAFF_INSERT` BEFORE INSERT ON `role_staff` FOR EACH ROW BEGIN 
				SET New.id = UUIDV4();
			END
		");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_staff');
    }
}
