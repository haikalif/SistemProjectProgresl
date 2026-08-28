<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jam_per_tanggal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_profile_id')->constrained('users_profile')->cascadeOnDelete();
            $table->foreignId('proyek_id')->constrained('proyek')->cascadeOnDelete();
            $table->date('tanggal');
            $table->decimal('jam', 5, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jam_per_tanggal');
    }
};
