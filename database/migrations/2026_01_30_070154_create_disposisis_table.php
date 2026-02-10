<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('disposisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_id')->constrained('surat');
            $table->foreignId('pengirim_id')->constrained('users');
            $table->foreignId('penerima_id')->constrained('users');
            $table->text('catatan')->nullable();
            $table->enum('status', ['Menunggu', 'Diterima', 'Diproses'])->default('Menunggu');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('disposisi');
    }
};