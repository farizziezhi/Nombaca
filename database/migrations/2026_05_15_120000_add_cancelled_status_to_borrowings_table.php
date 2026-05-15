<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tambahkan status 'cancelled' pada enum kolom status di tabel borrowings.
     *
     * Diperlukan agar fitur pembatalan peminjaman (CirculationController@cancel)
     * dapat menyimpan status pembatalan tanpa error "Data truncated".
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE borrowings MODIFY COLUMN status ENUM('pending', 'active', 'returned', 'overdue', 'cancelled') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Kembalikan enum ke daftar status semula tanpa 'cancelled'.
     *
     * Catatan: pastikan tidak ada baris dengan status='cancelled' sebelum rollback.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE borrowings MODIFY COLUMN status ENUM('pending', 'active', 'returned', 'overdue') NOT NULL DEFAULT 'pending'");
    }
};
