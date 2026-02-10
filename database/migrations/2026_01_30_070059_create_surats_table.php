<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengirim_id')->constrained('users');
            $table->foreignId('unit_tujuan_id')->nullable()->constrained('unit');
            $table->string('file');
            $table->text('catatan')->nullable();
            $table->enum('sifat', ['Rahasia', 'Penting', 'Disegerakan']);
            $table->decimal('nominal', 15, 2);
            $table->enum('status', ['Menunggu', 'Diproses', 'Disetujui', 'Ditolak', 'Selesai'])->default('Menunggu');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('surat');
    }
};