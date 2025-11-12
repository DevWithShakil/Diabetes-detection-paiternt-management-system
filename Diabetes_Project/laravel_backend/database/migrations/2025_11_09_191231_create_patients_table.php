<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->integer('age');
            $table->float('glucose');
            $table->float('blood_pressure');
            $table->float('skin_thickness');
            $table->float('insulin');
            $table->float('bmi');
            $table->float('diabetes_pedigree');
            $table->json('result')->nullable();
            $table->timestamps();

            // ✅ define foreign key constraint AFTER the column
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
