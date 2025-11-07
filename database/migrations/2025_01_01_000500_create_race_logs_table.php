<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('race_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('race_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->constrained('team_members')->cascadeOnDelete();
            $table->foreignId('checkpoint_id')->constrained('race_checkpoints')->cascadeOnDelete();
            $table->timestamp('reached_at');
            $table->timestamps();

            $table->unique(['race_id','member_id','checkpoint_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('race_logs'); }
};
