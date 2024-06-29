<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKehadiranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kehadiran', function (Blueprint $table) {
            $table->id();
            $table->string('status_presensi',100);
            $table->dateTime('waktu_presensi')->nullable();
            // $table->longText('deskripsi')->default('bekerja')->nullable();
            $table->longText('deskripsi')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kehadiran');
    }
}
