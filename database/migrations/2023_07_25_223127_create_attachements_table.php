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
        Schema::create('attachements', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('relation_id')->nullable();
            $table->string('relation_text')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('link')->nullable();
            $table->string('deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachements');
    }
};
