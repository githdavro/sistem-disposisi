// database/migrations/2026_02_10_070101_add_nomor_surat_to_surats_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('surat', function (Blueprint $table) {
            $table->string('nomor_surat', 100)->unique()->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('surat', function (Blueprint $table) {
            $table->dropColumn('nomor_surat');
        });
    }
};