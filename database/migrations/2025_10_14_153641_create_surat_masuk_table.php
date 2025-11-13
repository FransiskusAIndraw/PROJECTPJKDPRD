<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->enum('status_screening', ['pending','approved','rejected'])->default('pending');
            $table->text('catatan_screening')->nullable();
            $table->text('catatan_tusekwan')->nullable();
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->string('pengirim');
            $table->string('perihal');
            $table->string('file_surat');
            $table->enum('status', [
                'draft','terkirim_ke_tusekwan','menunggu_verifikasi','perlu_revisi','terverifikasi',
                'didisposisikan_ke_pimpinan','diterima_pimpinan','didisposisikan_oleh_pimpinan',
                'diterima_sekwan','diteruskan_ke_kabag','diteruskan_ke_tusekre','diterima_kabag',
                'selesai_diproses','diarsipkan','dihapus'
            ])->default('draft');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->foreignId('screened_by')->nullable()->constrained('users');
            $table->enum('diteruskan_ke_role', ['kabag_persidangan','kabag_keuangan','kabag_umum','tusekre'])->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('surat_masuk');
    }
};
