<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade'); // assuming teachers are in users table
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            
            $table->date('date');
            $table->enum('status', ['present', 'absent'])->default('present');
            
            $table->timestamps();
            $table->unique(['teacher_id', 'student_id', 'date']); // prevent duplicate attendance
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
