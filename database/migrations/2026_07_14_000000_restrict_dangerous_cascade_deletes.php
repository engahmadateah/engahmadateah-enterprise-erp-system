<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Deleting a department / user / product / customer used to silently delete
 * employees, journal entries, sales, purchases... (ON DELETE CASCADE).
 * Those are now RESTRICT: the delete is refused and a friendly message shown
 * (see bootstrap/app.php).
 */
return new class extends Migration
{
    /** table => [column => referenced table] */
    private array $map = [
        'employees'           => ['department_id' => 'departments'],
        'journal_entries'     => ['user_id'       => 'users'],
        'journal_entry_lines' => ['account_id'    => 'accounts'],
        'sales'               => ['user_id' => 'users', 'product_id' => 'products', 'customer_id' => 'customers'],
        'purchases'           => ['supplier_id' => 'suppliers', 'product_id' => 'products', 'warehouse_id' => 'warehouses'],
        'stock_movements'     => ['user_id' => 'users', 'product_id' => 'products'],
    ];

    public function up(): void
    {
        $this->rewire(restrict: true);
    }

    public function down(): void
    {
        $this->rewire(restrict: false);
    }

    private function rewire(bool $restrict): void
    {
        // sqlite (phpunit) cannot alter foreign keys reliably; nothing to protect there
        if (! in_array(Schema::getConnection()->getDriverName(), ['mysql', 'mariadb', 'pgsql'])) {
            return;
        }

        foreach ($this->map as $table => $columns) {
            foreach ($columns as $column => $ref) {

                $exists = collect(Schema::getForeignKeys($table))
                    ->contains(fn ($fk) => $fk['columns'] === [$column]);

                Schema::table($table, function (Blueprint $t) use ($column, $ref, $exists, $restrict) {
                    if ($exists) {
                        $t->dropForeign([$column]);
                    }

                    $fk = $t->foreign($column)->references('id')->on($ref);

                    $restrict ? $fk->restrictOnDelete() : $fk->cascadeOnDelete();
                });
            }
        }
    }
};
