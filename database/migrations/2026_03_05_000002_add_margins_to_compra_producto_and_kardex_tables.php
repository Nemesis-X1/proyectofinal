<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('compra_producto')) {
            Schema::table('compra_producto', function (Blueprint $table) {
                if (!Schema::hasColumn('compra_producto', 'margen_porcentaje')) {
                    $table->decimal('margen_porcentaje', 5, 2)->nullable();
                }
                if (!Schema::hasColumn('compra_producto', 'margen_fijo')) {
                    $table->decimal('margen_fijo', 10, 2)->nullable();
                }
            });
        }

        if (Schema::hasTable('kardex')) {
            Schema::table('kardex', function (Blueprint $table) {
                if (!Schema::hasColumn('kardex', 'margen_porcentaje')) {
                    $table->decimal('margen_porcentaje', 5, 2)->nullable();
                }
                if (!Schema::hasColumn('kardex', 'margen_fijo')) {
                    $table->decimal('margen_fijo', 10, 2)->nullable();
                }
            });

            // Update enum in kardex table
            DB::statement("ALTER TABLE kardex MODIFY COLUMN tipo_transaccion ENUM('COMPRA', 'VENTA', 'AJUSTE_POSITIVO', 'AJUSTE_NEGATIVO', 'DEVOLUCION', 'APERTURA') NOT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('compra_producto')) {
            Schema::table('compra_producto', function (Blueprint $table) {
                $table->dropColumn(['margen_porcentaje', 'margen_fijo']);
            });
        }

        if (Schema::hasTable('kardex')) {
            Schema::table('kardex', function (Blueprint $table) {
                $table->dropColumn(['margen_porcentaje', 'margen_fijo']);
            });

            DB::statement("ALTER TABLE kardex MODIFY COLUMN tipo_transaccion ENUM('COMPRA', 'VENTA', 'AJUSTE', 'APERTURA') NOT NULL");
        }
    }
};
