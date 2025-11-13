<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('arsip', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_id')->constrained('surat_masuk')->onDelete('cascade');
            $table->foreignId('disposisi_id')->nullable()->constrained('disposisi')->onDelete('cascade');
            $table->foreignId('arsipkan_oleh')->nullable()->constrained('users');
            $table->string('arsipkan_oleh_role')->nullable();
            $table->string('nomor_surat');
            $table->date('tanggal_surat')->nullable();
            $table->string('pengirim')->nullable();
            $table->string('perihal', 500)->nullable();
            $table->string('file_surat')->nullable();
            $table->text('instruksi')->nullable();
            $table->string('lokasi_file');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('arsip');
    }
};
