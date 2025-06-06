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
        Schema::create('diseases', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('category', ['viral', 'bacterial', 'fungal', 'parasitic', 'genetic', 'autoimmune', 'other']);
            $table->string('symptoms')->nullable();
            $table->string('prevention')->nullable();
            $table->string('treatment')->nullable();
            $table->string('image')->nullable(); // URL or path to the disease image
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diseases');
    }
};
