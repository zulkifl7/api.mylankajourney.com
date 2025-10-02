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
        Schema::table('countries', function (Blueprint $table) {
            $table->string('flag')->nullable()->change();
            $table->string('currency')->nullable()->change();
            $table->string('image')->nullable()->change();
            $table->string('video_url')->nullable()->change();
            $table->string('poster_url')->nullable()->change();
            $table->string('timezone')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->string('flag')->nullable(false)->change();
            $table->string('currency')->nullable(false)->change();
            $table->string('image')->nullable(false)->change();
            $table->string('video_url')->nullable(false)->change();
            $table->string('poster_url')->nullable(false)->change();
            $table->string('timezone')->nullable(false)->change();
        });
    }
};