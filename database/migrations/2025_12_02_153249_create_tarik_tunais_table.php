<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tarik_tunais', function (Blueprint $table) {
            $table->id();

            $table->string('kode_transaksi')->unique();

            $table->unsignedBigInteger('user_id');        // customer
            $table->unsignedBigInteger('petugas_id')->nullable(); // petugas lapangan
            $table->unsignedBigInteger('assigned_by')->nullable(); // admin yang assign

            $table->unsignedBigInteger('jumlah');
            $table->unsignedBigInteger('biaya_admin')->default(0);
            $table->unsignedBigInteger('total_dibayar')->nullable();

            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->unsignedBigInteger('lokasi_cod_id')->nullable();

            // ========== BUKTI CUSTOMER ==========
            $table->string('bukti_bayar_customer')->nullable();
            $table->timestamp('waktu_upload_bukti_customer')->nullable();
            
            // ========== BUKTI PETUGAS ==========
            $table->string('bukti_serah_terima_petugas')->nullable();
            $table->timestamp('waktu_upload_bukti_petugas')->nullable();
            $table->text('catatan_serah_terima')->nullable();

            // ========== TIMELINE ==========
            $table->timestamp('waktu_diproses')->nullable();
            $table->timestamp('waktu_dalam_perjalanan')->nullable();
            $table->timestamp('waktu_diserahkan')->nullable();
            $table->timestamp('waktu_verifikasi_qris')->nullable(); // TAMBAHKAN INI UNTUK QRIS COD
            $table->timestamp('waktu_selesai')->nullable();
            $table->timestamp('waktu_dibatalkan')->nullable();

            // ========== STATUS ==========
            $table->enum('status', [
                'pending',              
                'menunggu_admin',       
                'menunggu_pembayaran',  // Customer perlu bayar
                'menunggu_verifikasi_admin', // Sudah upload bukti, tunggu verifikasi
                'menunggu_verifikasi_qris', // STATUS BARU: Untuk QRIS COD
                'diproses',             // Admin sudah verifikasi
                'dalam_perjalanan',    
                'menunggu_serah_terima',
                'selesai',
                'dibatalkan_customer',
                'dibatalkan_admin'
            ])->default('pending');

            // ========== CATATAN ==========
            $table->text('catatan_admin')->nullable();
            $table->text('catatan_petugas')->nullable();
            $table->text('catatan_customer')->nullable();

            // ========== FLAG UNTUK QRIS COD ==========
            $table->boolean('is_qris_cod')->default(false); // TAMBAHKAN INI

            $table->timestamps();

            // =============================
            // FOREIGN KEY
            // =============================

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('petugas_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('assigned_by')->references('id')->on('users')->onDelete('set null');

            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('set null');
            $table->foreign('lokasi_cod_id')->references('id')->on('lokasi_cod')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarik_tunais');
    }
};