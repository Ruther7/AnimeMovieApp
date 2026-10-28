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
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('synopsis')->nullable();
            $table->json('genres')->nullable();
            $table->integer('release_year')->nullable();
            $table->string('status')->default('ongoing');
            $table->decimal('rating', 3, 1)->nullable();
            $table->string('poster_url')->nullable();
            $table->string('banner_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};
