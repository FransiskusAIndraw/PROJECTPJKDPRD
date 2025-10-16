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
        Schema::create('surat_masuk', function (Blueprint $table) {
    $table->id();
    $table->string('nomor_surat');
    $table->date('tanggal_surat');
    $table->string('pengirim');
    $table->string('perihal');
    $table->string('file_surat'); // uploaded PDF
    $table->enum('status', ['draft', 'reviewed', 'disposisi', 'completed'])->default('draft');
    $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // TU Sekre
    $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete(); // TU Sekwan
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
