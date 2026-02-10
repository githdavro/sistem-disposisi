// database/migrations/2026_02_10_070100_add_kode_unit_to_units_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('unit', function (Blueprint $table) {
            $table->string('kode_unit', 10)->unique()->nullable()->after('nama_unit');
        });
    }

    public function down()
    {
        Schema::table('unit', function (Blueprint $table) {
            $table->dropColumn('kode_unit');
        });
    }
};