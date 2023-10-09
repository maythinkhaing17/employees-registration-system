<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class create employee uploads table.
 * 
 * @author May Thin Khaing
 * @created 21/06/2023
 * @return void
 */
class CreateEmployeeUploadsTable extends Migration
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
        Schema::create('employee_uploads', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('employee_id');
            $table->string('file_path');
            $table->integer('file_size');
            $table->string('file_extension', 50);
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
        Schema::dropIfExists('employee_uploads');
    }
}
