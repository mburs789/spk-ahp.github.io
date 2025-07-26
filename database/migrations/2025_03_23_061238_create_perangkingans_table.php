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
        Schema::create('perangkingans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained()->onDelete('cascade');  // Menyimpan ID karyawan
            $table->integer('ranking');  // Kolom untuk menyimpan nilai ranking
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');  // Status perankingan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perangkingans');
    }
};
