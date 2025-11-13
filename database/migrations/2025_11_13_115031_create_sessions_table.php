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
        Schema::create('sessions', function (Blueprint $table) {
            // id string primary sesuai default Laravel
            $table->string('id')->primary();
            // optional: user reference jika mau
            $table->foreignId('user_id')->nullable()->index();
            // ip address (IPv6 compatible)
            $table->string('ip_address', 45)->nullable();
            // user agent (browser) bisa panjang
            $table->text('user_agent')->nullable();
            // payload session (serialize)
            $table->text('payload');
            // last activity timestamp (unix)
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};