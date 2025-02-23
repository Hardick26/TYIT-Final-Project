<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->dropColumn('leave_type');
        });
    }

    public function down()
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->string('leave_type')->after('end_date')->nullable();
        });
    }
};