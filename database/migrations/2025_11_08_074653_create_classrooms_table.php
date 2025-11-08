<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. "10-A" or "Grade 10"
            $table->string('section')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable()->index();
            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
