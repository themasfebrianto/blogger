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
        Schema::create('yaumi_streaks', function (Blueprint $table) {
            $table->id();

            // relasi ke user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // tanggal mulai dan akhir streak
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // jumlah streak terpanjang & saat ini
            $table->integer('longest_streak')->default(0);
            $table->integer('current_streak')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yaumi_streaks');
    }
};
