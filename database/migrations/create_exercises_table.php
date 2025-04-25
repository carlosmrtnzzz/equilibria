<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['cardio', 'strength', 'stretching', 'mobility']);
            $table->text('description');
            $table->integer('estimated_calories');
            $table->enum('difficulty_level', ['low', 'medium', 'high']);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('exercises');
    }
};
