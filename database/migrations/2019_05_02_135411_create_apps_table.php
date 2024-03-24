<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->string('appid')->nullable()->unique();
            $table->string('token');
            $table->string('icon')->nullable();
            $table->string('invoice_num_prefix')->nullable();
            $table->string('remote_auth_url')->nullable();
            $table->string('remote_staff_data_url')->nullable();
            $table->string('remote_product_data_url')->nullable();
            $table->string('expires_in')->nullable();
            $table->dateTime('created_at')->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->dateTime('updated_at')->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->dateTime('deleted_at')->nullable();
            $table->uuid('user_id');
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
        });

        DB::unprepared(
            "DROP TRIGGER IF EXISTS `AFTER_APPS_INSERT`;CREATE TRIGGER `AFTER_APPS_INSERT` AFTER INSERT ON `apps` FOR EACH ROW BEGIN
                SELECT SUBSTR(name,1,3) INTO @prefix from apps WHERE id = New.id;
                INSERT INTO invoice_number (prefix,alpha_index, number, app_id) VALUES (CONCAT(@prefix,'INV'),1,1,New.id);

                INSERT INTO customer_number(prefix,alpha_index,number,app_id) VALUES(CONCAT(@prefix,'CUS'),1,1,New.id);

                INSERT INTO expenses_number(prefix,alpha_index,number,app_id) VALUES(CONCAT(@prefix,'EXP'),1,1,New.id);

                INSERT INTO credit_number(prefix,alpha_index,number,app_id) VALUES(CONCAT(@prefix,'CRD'),1,1,New.id);
                
                INSERT INTO creditor_numbers(prefix,alpha_index,number,app_id) VALUES(CONCAT(@prefix,'SUP'),1,1,New.id);
                
                INSERT INTO purchase_invoice_number (prefix,alpha_index,number,app_id) VALUES(CONCAT(@prefix,'PUR'),1,1,New.id);
                
                INSERT INTO transaction_numbers (prefix,alpha_index,number,app_id) VALUES(CONCAT(@prefix,'TRN'),1,1,New.id);
                
                INSERT INTO bank_numbers (prefix,alpha_index,number,app_id) VALUES(CONCAT(@prefix,'BNK'),1,1,New.id);
                
                INSERT INTO cashbook_numbers (prefix,alpha_index,number,app_id) VALUES(CONCAT(@prefix,'CSH'),1,1,New.id);
                
                INSERT INTO purchase_return_numbers (prefix,alpha_index,number,app_id) VALUES(CONCAT(@prefix,'PRN'),1,1,New.id);
                
                INSERT INTO debit_note_numbers (prefix,alpha_index,number,app_id) VALUES(CONCAT(@prefix,'DBN'),1,1,New.id);
                
                INSERT INTO debit_note_transaction_numbers (prefix,alpha_index,number,app_id) VALUES(CONCAT(@prefix,'DNT'),1,1,New.id);

            END
            "
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app');
    }
}
