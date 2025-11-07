<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->string('member_name');
            $table->foreignId('race_id')->nullable()->constrained('races')->nullOnDelete();
            $table->timestamps();

            $table->unique(['team_id','member_name']);
        });
    }
    public function down(): void { Schema::dropIfExists('team_members'); }
};
