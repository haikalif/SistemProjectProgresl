<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesan', function (Blueprint $table) {
            $table->id();
            $table->string('pengirim', 100);
            $table->string('penerima', 100);
            $table->text('isi');
            $table->foreignId('parent_id')->nullable()->constrained('pesan')->nullOnDelete();
            $table->dateTime('tgl_pesan');
            $table->foreignId('jenis_id')->nullable()->constrained('jenis_pesan')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesan');
    }
};
