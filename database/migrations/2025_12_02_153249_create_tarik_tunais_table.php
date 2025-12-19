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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('petugas_id')->nullable();
            $table->unsignedBigInteger('jumlah');
            $table->unsignedBigInteger('payment_method_id')->nullable(); // UBAH INI
            $table->unsignedBigInteger('lokasi_cod_id')->nullable();
            $table->string('bukti_bayar_customer')->nullable();
            $table->string('bukti_serah_terima_petugas')->nullable();
            $table->timestamp('waktu_diserahkan')->nullable();
            $table->enum('status', [
                'pending',     
                'diproses',     
                'menunggu_petugas', 
                'dalam_perjalanan', 
                'selesai',      
                'dibatalkan'
            ])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

            // RELASI
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('petugas_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('set null'); // UBAH INI
            $table->foreign('lokasi_cod_id')->references('id')->on('lokasi_cod')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarik_tunais');
    }
};