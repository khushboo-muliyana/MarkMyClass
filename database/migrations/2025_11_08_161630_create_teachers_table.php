<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('phone')->nullable();
        $table->enum('gender', ['male','female','other'])->nullable();
        $table->string('qualification')->nullable();
        $table->date('join_date')->nullable();
        $table->unsignedBigInteger('classroom_id')->nullable()->index();
        $table->string('photo_path')->nullable();
        $table->timestamps();

        // $table->foreign('classroom_id')->references('id')->on('classrooms')->nullOnDelete();

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
