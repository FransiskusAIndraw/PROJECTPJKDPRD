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
        Schema::table('surat_masuk', function (Blueprint $table) {
             $table->enum('status_screening', ['pending', 'approved', 'rejected'])
              ->default('pending')
              ->after('id');
            

        $table->text('catatan_tusekwan')->nullable()->after('status_screening');
        $table->foreignId('screened_by')->nullable()->constrained('users')->after('catatan_tusekwan');
    });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            // drop foreign key first to avoid constraint errors, then drop columns
            $table->dropForeign(['screened_by']);
            $table->dropColumn(['status_screening', 'catatan_tusekwan', 'screened_by']);
        });
    }
};
