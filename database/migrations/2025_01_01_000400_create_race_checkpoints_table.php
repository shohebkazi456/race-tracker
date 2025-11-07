<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('race_checkpoints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('race_id')->constrained()->cascadeOnDelete();
            $table->string('checkpoint_name');
            $table->unsignedInteger('order_no');
            $table->timestamps();

            $table->unique(['race_id','order_no']);
        });
    }
    public function down(): void { Schema::dropIfExists('race_checkpoints'); }
};
