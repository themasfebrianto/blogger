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
        Schema::create('yaumi_logs', function (Blueprint $table) {
            $table->id();

            // relasi ke users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // relasi ke yaumi_activities
            $table->foreignId('activity_id')->constrained('yaumi_activities')->onDelete('cascade');

            // tanggal ibadah yaumi
            $table->date('date');

            // nilai atau skor (misal 1 = dilakukan, 0 = tidak)
            $table->integer('value')->default(0);

            // catatan tambahan opsional
            $table->string('note', 255)->nullable();

            $table->timestamps();

            // optional: untuk memastikan kombinasi unik per user + activity + date
            $table->unique(['user_id', 'activity_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yaumi_logs');
    }
};
