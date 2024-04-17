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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('site_name');
            $table->string('title');
            $table->unsignedBigInteger('activity_id');
            $table->foreign('activity_id')->references('id')->on('activities');
            $table->string('place');
            $table->date('date');
            $table->integer('distance');
            $table->integer('priority');
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('last_modif')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
