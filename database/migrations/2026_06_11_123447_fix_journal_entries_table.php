<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('journal_entries', function (Blueprint $table) {

            // إذا الأعمدة مش موجودة رح تنضاف

            if (!Schema::hasColumn('journal_entries', 'entry_number')) {
                $table->string('entry_number')->unique()->after('id');
            }

            if (!Schema::hasColumn('journal_entries', 'entry_date')) {
                $table->dateTime('entry_date')->after('entry_number');
            }

            if (!Schema::hasColumn('journal_entries', 'description')) {
                $table->text('description')->nullable()->after('entry_date');
            }

            if (!Schema::hasColumn('journal_entries', 'user_id')) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->constrained()
                    ->cascadeOnDelete()
                    ->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('journal_entries', function (Blueprint $table) {

            $table->dropForeign(['user_id']);

            $table->dropColumn([
                'entry_number',
                'entry_date',
                'description',
                'user_id'
            ]);
        });
    }
};