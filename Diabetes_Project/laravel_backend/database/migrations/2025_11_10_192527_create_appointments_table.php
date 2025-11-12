<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('patient_id');
    $table->unsignedBigInteger('doctor_id');
    $table->date('appointment_date');
    $table->string('status')->default('pending');
    $table->time('time')->nullable();
    $table->text('notes')->nullable();
    $table->timestamps();

    // ✅ Correct Foreign Keys
    $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
    $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
