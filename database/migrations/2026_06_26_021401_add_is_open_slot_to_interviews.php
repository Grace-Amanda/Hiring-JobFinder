<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            // NULL berarti open slot (belum assign ke kandidat tertentu)
            // Ubah applicant_id & job_vacancy_id jadi nullable agar bisa buat open slot
            $table->boolean('is_open_slot')->default(false)->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            $table->dropColumn('is_open_slot');
        });
    }
};