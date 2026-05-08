<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_settings', function (Blueprint $table) {
            $table->id();
            $table->time('work_start')->default('08:00:00');
            $table->time('work_end')->default('17:00:00');
            $table->unsignedSmallInteger('grace_minutes')->default(0);
            $table->decimal('late_penalty_per_minute', 12, 2)->default(0);
            $table->decimal('absence_penalty_per_day', 12, 2)->default(0);
            $table->decimal('bpjs_percent', 5, 2)->default(0);
            $table->decimal('tax_percent', 5, 2)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_settings');
    }
};
