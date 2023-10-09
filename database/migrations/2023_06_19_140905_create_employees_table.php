<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * create employees table.
 * 
 * @author May Thin Khaing
 * @created 21/06/2023
 * @return void
 */
class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @author May Thin Khaing
     * @created 21/06/2023
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('employee_id')->unique();
            $table->string('employee_code', 50);
            $table->string('employee_name', 50);
            $table->string('nrc_number', 50);
            $table->string('password', 255);
            $table->string('email_address', 255);
            $table->integer('gender')->nullable();
            $table->date('date_of_birth');
            $table->integer('martial_status')->nullable();
            $table->longText('address')->nullable();
            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @author May Thin Khaing
     * @created 21/06/2023
     * 
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
