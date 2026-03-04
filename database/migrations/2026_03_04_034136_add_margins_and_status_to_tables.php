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
        Schema::table('inventario', function (Blueprint $table) {
            $table->decimal('margen_porcentaje', 5, 2)->nullable()->after('cantidad');
            $table->decimal('margen_fijo', 10, 2)->nullable()->after('margen_porcentaje');
            $table->boolean('estado')->default(true)->after('margen_fijo');
        });

        Schema::table('kardex', function (Blueprint $table) {
            $table->decimal('margen_porcentaje', 5, 2)->nullable()->after('costo_unitario');
            $table->decimal('margen_fijo', 10, 2)->nullable()->after('margen_porcentaje');
        });

        Schema::table('compra_producto', function (Blueprint $table) {
            $table->decimal('margen_porcentaje', 5, 2)->nullable()->after('precio_compra');
            $table->decimal('margen_fijo', 10, 2)->nullable()->after('margen_porcentaje');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventario', function (Blueprint $table) {
            $table->dropColumn(['margen_porcentaje', 'margen_fijo', 'estado']);
        });

        Schema::table('kardex', function (Blueprint $table) {
            $table->dropColumn(['margen_porcentaje', 'margen_fijo']);
        });

        Schema::table('compra_producto', function (Blueprint $table) {
            $table->dropColumn(['margen_porcentaje', 'margen_fijo']);
        });
    }
};
