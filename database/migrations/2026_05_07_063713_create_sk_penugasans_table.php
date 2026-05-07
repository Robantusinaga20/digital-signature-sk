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
        Schema::create('sk_penugasans', function (Blueprint $table) {
            $table->id('id_sk');
            $table->string('nomor_sk', 30);
            $table->date('tanggal_sk');
            $table->text('perihal_sk');
            $table->string('pengesah', 100);
            $table->string('sk_path', 255);
            $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_penugasans');
    }
};
