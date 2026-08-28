<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keterangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bagian_id')->constrained('bagian')->cascadeOnDelete();
            $table->foreignId('proyek_id')->constrained('proyek')->cascadeOnDelete();
            $table->date('tanggal');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keterangan');
    }
};
