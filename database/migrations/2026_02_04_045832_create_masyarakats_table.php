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
        Schema::create('masyarakats', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->unique();

            $table->string('nik', 16)->unique();
            $table->string('nama_lengkap');
            $table->text('alamat');

            $table->string('desa');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('provinsi');

            $table->string('pekerjaan')->nullable();
            $table->decimal('penghasilan', 15, 2)->default(0);
            $table->unsignedTinyInteger('jumlah_tanggungan')->default(0);

            $table->enum('status_rumah', ['milik', 'sewa', 'kontrak'])->nullable();
            $table->enum('status_ekonomi', ['miskin', 'rentan', 'mampu'])->default('rentan');

            $table->enum('status_penerima', ['layak', 'tidak_layak'])->default('tidak_layak');
            $table->enum('status_penyaluran', ['belum', 'sudah'])->default('belum');

            $table->date('tanggal_penyaluran')->nullable();
            $table->decimal('nominal_bantuan', 15, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masyarakats');
    }
};
