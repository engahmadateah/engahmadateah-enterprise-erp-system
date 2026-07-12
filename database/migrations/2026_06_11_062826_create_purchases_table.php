<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {

            $table->id();

            $table->foreignId('supplier_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('warehouse_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('quantity');

            $table->decimal(
                'unit_price',
                10,
                2
            );

            $table->decimal(
                'total',
                10,
                2
            );

            $table->date('purchase_date');

            $table->text('notes')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};