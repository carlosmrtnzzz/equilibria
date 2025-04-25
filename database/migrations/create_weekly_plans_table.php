<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('weekly_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->longText('meals_json');
            $table->string('pdf_url')->nullable();
            $table->unsignedTinyInteger('changes_left')->default(3);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('weekly_plans');
    }
};
