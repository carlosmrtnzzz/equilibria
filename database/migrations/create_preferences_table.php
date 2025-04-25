<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_celiac')->default(false);
            $table->boolean('is_lactose_intolerant')->default(false);
            $table->text('disliked_foods')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('preferences');
    }
};
