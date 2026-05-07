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
        Schema::create('tanda_tangans', function (Blueprint $table) {
            $table->id('id_tt');
            $table->foreignId('id_sk')->constrained('sk_penugasans', 'id_sk')->onDelete('cascade');
            $table->foreignId('id_kunci')->constrained('kuncis', 'id_kunci')->onDelete('cascade');
            $table->text('plaintext');
            $table->text('ciphertext');
            $table->string('qr_path', 255)->nullable();
            $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanda_tangans');
    }
};
