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
        Schema::create('yaumi_activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');                   // Nama aktivitas
            $table->text('description')->nullable(); // Deskripsi (opsional)
            $table->string('icon')->nullable();      // Nama ikon (opsional)
            $table->integer('order')->default(0);    // Urutan untuk sorting
            $table->boolean('is_active')->default(true); // Status aktif
            $table->timestamps();                    // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yaumi_activities');
    }
};
