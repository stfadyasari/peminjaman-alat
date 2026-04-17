<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->unsignedInteger('good_stock')->default(0)->after('stock');
            $table->unsignedInteger('minor_damage_stock')->default(0)->after('good_stock');
            $table->unsignedInteger('major_damage_stock')->default(0)->after('minor_damage_stock');
        });

        DB::table('devices')->update([
            'good_stock' => DB::raw("CASE WHEN `condition` = 'baik' OR `condition` IS NULL THEN `stock` ELSE 0 END"),
            'minor_damage_stock' => DB::raw("CASE WHEN `condition` = 'rusak ringan' THEN `stock` ELSE 0 END"),
            'major_damage_stock' => DB::raw("CASE WHEN `condition` = 'rusak berat' THEN `stock` ELSE 0 END"),
        ]);
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn(['good_stock', 'minor_damage_stock', 'major_damage_stock']);
        });
    }
};
