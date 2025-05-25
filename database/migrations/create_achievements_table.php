<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type'); // 'generate_plan', 'login_streak', etc.
            $table->integer('target_value')->default(1);
            $table->string('reward_type')->nullable(); // 'extra_swap', 'extra_regeneration', etc.
            $table->integer('reward_amount')->nullable();
            $table->string('icon')->nullable(); // archivo imagen, ej: plan1.png
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
