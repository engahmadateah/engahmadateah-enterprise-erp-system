<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('tickets', function (Blueprint $table) {

        $table->string('teamviewer_id')
            ->nullable()
            ->after('description');

        $table->string('ip_address')
            ->nullable()
            ->after('teamviewer_id');

        $table->json('attachments')
            ->nullable()
            ->after('ip_address');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            //
        });
    }
};
