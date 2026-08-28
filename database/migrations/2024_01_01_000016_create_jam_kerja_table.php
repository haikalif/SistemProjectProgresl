<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jam_kerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_profile_id')->constrained('users_profile')->cascadeOnDelete();
            $table->string('no_wbs', 50)->nullable();
            $table->string('kode_proyek', 50)->nullable();
            $table->foreignId('proyek_id')->constrained('proyek')->cascadeOnDelete();
            $table->foreignId('aktivitas_id')->constrained('aktivitas')->cascadeOnDelete();
            $table->date('tanggal');
            $table->decimal('jumlah_jam', 5, 2);
            $table->text('keterangan')->nullable();
            $table->foreignId('status_id')->nullable()->constrained('status_jam_kerja')->nullOnDelete();
            $table->foreignId('mode_id')->nullable()->constrained('mode_jam_kerja')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jam_kerja');
    }
};
