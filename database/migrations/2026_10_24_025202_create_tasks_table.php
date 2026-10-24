<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('Mata_Kuliah');
            $table->string('Judul_Tugas');
            $table->text('Keterangan');
            $table->date('Deadline');
            $table->time('Jam_Tenggat');
            $table->enum('Prioritas', ['Rendah', 'Sedang', 'Tinggi']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
