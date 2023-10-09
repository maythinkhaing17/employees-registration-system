<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add foreign keys to employee uploads table.
 * 
 * @author May Thin Khaing
 * @created 21/06/2023
 * @return void
 */

class AddForeignKeyTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * @author May Thin Khaing
     * @created 21/06/2023
     * @return void
     */
    public function up()
    {
        Schema::table('employee_uploads', function (Blueprint $table) {
            $table->foreign('employee_id')->references('employee_id')->on('employees')->onDelete('cascade');
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
        //
    }
}
