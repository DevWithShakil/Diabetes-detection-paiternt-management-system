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
       Schema::create('model_stats', function (Blueprint $table) {
            $table->id();
            $table->string('model_name'); // e.g. 'Random Forest'
            $table->decimal('accuracy',5,2)->nullable();
            $table->integer('runs')->default(0);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_stats');
    }
};
