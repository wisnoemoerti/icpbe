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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('no_tiket')->unique();
            $table->string('judul_tiket');
            $table->enum('tipe_tiket', ['Task', 'Bug']);
            $table->enum('assigned_to', ['Anggit', 'Tri', 'Banu']);
            $table->text('description')->nullable();
            $table->enum('label', ['To Do', 'Doing','Testing','Done']);
            $table->enum('project_name', ['ECare Phase 2', 'ECare Phase 3']);
            $table->integer('index');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
