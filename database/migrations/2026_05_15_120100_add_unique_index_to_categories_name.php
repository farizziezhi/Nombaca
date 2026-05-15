<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan unique constraint pada kolom categories.name.
     *
     * Diperlukan agar nama kategori tidak boleh duplikat (mis. "Fiksi" tidak boleh ada dua).
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->unique('name');
        });
    }

    /**
     * Hapus unique constraint pada kolom categories.name.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });
    }
};
