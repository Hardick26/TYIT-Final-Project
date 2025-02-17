<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('task_completion_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('completed_by')->constrained('users')->onDelete('cascade');
            $table->text('completion_notes')->nullable();
            $table->timestamp('completed_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_completion_records');
    }
};