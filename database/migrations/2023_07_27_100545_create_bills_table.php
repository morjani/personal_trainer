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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->string('reference')->nullable();
            $table->integer('state')->default(0);
            $table->string('payment_method')->nullable();
            $table->decimal('total_ht',11,2)->nullable();
            $table->decimal('total_ttc',11,2)->nullable();
            $table->integer('tva')->nullable();
            $table->timestamp('date')->nullable();
            $table->timestamp('event_date')->nullable();
            $table->text('description')->nullable();
            $table->text('customer_address')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('proforma_id')->default(0);
            $table->integer('bill_id')->default(0);
            $table->integer('deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
