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
        DB::statement("ALTER TABLE ventas MODIFY COLUMN metodo_pago ENUM('EFECTIVO', 'QR') NOT NULL");
        DB::statement("ALTER TABLE compras MODIFY COLUMN metodo_pago ENUM('EFECTIVO', 'QR') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE ventas MODIFY COLUMN metodo_pago ENUM('EFECTIVO', 'QR') NOT NULL");
        DB::statement("ALTER TABLE compras MODIFY COLUMN metodo_pago ENUM('EFECTIVO', 'QR') NOT NULL");
    }
};
