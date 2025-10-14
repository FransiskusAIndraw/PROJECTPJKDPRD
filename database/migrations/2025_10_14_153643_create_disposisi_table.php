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
        Schema::create('disposisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_id')->constrained('surat_masuk')->onDelete('cascade');
            $table->foreignId('dari_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('ke_user')->constrained('users')->onDelete('cascade');
            $table->text('instruksi')->nullable();
            $table->timestamp('tgl_disposisi')->useCurrent();
            $table->enum('status_dispo', ['pending', 'dibaca', 'selesai'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisi');
    }
};
