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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('email');
            $table->string('phone');
            $table->string('service');
            $table->string('package');
            $table->string('invoice')->nullable();
            $table->decimal('total_payment', 10, 2);
            $table->decimal('initial_payment', 10, 2); 
            $table->decimal('remaining_payment', 10, 2);
            $table->string('payment_status')->default('pending');
            $table->date('starting_date');
            $table->date('ending_date');
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
