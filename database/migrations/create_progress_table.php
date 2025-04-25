<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->decimal('weight_kg', 5, 2);
            $table->decimal('imc', 5, 2);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('progress');
    }
};
