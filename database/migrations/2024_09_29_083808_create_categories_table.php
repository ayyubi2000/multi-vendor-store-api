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
        Schema::create('categories', function (Blueprint $table) {
                $table->id('id');
                $table->json('name');
                $table->string('slug');
                $table->string('icon', 100)->nullable();
                $table->string('image', 100)->nullable();
                $table->smallInteger('coefficient')->nullable()->default(3);
                $table->boolean('is_active')->default(0);
                $table->nestedSet();
                $table->unsignedBigInteger('sort')->nullable();
                $table->softDeletes();
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
