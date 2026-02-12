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
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('university_name')->unique();
            $table->string('country');
            $table->string('city');
            $table->enum('partner_type', ['Partner', 'Non-Partner'])->default('Non-Partner');
            $table->integer('programs');
            $table->string('application_fee');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};
