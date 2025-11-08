<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('roll_number')->nullable();
            $table->unsignedBigInteger('classroom_id')->nullable();
            $table->string('phone')->nullable();
            $table->enum('gender', ['male','female','other'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('guardian_name')->nullable();
            $table->text('address')->nullable();
            $table->string('photo_path')->nullable();
            $table->timestamps();

            // Unique inside each class
            $table->unique(['roll_number', 'classroom_id']);

            $table->foreign('classroom_id')
                ->references('id')
                ->on('classrooms')
                ->nullOnDelete();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
