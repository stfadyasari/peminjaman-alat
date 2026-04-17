<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('loans', 'payment_method')) {
            Schema::table('loans', function (Blueprint $table) {
                $table->string('payment_method')->nullable()->after('fine_amount');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('loans', 'payment_method')) {
            Schema::table('loans', function (Blueprint $table) {
                $table->dropColumn('payment_method');
            });
        }
    }
};
