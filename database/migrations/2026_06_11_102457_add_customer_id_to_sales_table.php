<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {

            $table->foreignId('customer_id')
                ->after('warehouse_id')
                ->constrained()
                ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {

            $table->dropForeign(['customer_id']);

            $table->dropColumn('customer_id');

        });
    }
};