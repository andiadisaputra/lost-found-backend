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
    Schema::create('reports', function (Blueprint $table) {

    $table->id();

    $table->foreignId('user_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->foreignId('category_id')
          ->constrained()
          ->cascadeOnDelete();

    // Barang Hilang / Ditemukan
    $table->enum('type', ['lost', 'found']);

    // Judul
    $table->string('title');

    // Deskripsi
    $table->text('description');

    // Lokasi
    $table->string('location_name');

    // Detail lokasi
    $table->text('address')->nullable();

    // Google Maps
    $table->decimal('latitude', 10, 8)->nullable();
    $table->decimal('longitude', 11, 8)->nullable();

    // Informasi barang
    $table->string('brand')->nullable();
    $table->string('color')->nullable();

    // Tanggal kejadian
    $table->date('incident_date');

    // Status laporan
    $table->enum('status', [
        'open',
        'claimed',
        'closed'
    ])->default('open');

    // Anonim
    $table->boolean('is_anonymous')->default(false);

    // Nomor WhatsApp
    $table->string('contact_phone', 20);

    $table->softDeletes();

    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
