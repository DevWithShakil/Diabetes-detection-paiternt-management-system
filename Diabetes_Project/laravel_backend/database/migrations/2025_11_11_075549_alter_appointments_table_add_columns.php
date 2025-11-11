<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'doctor_id')) {
                $table->foreignId('doctor_id')->nullable()->constrained('doctors')->onDelete('cascade');
            }

            if (!Schema::hasColumn('appointments', 'appointment_date')) {
                $table->date('appointment_date')->nullable();
            }

            if (!Schema::hasColumn('appointments', 'status')) {
                $table->string('status')->default('pending');
            }

            if (!Schema::hasColumn('appointments', 'notes')) {
                $table->text('notes')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'doctor_id')) {
                $table->dropConstrainedForeignId('doctor_id');
            }
            if (Schema::hasColumn('appointments', 'appointment_date')) {
                $table->dropColumn('appointment_date');
            }
            if (Schema::hasColumn('appointments', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('appointments', 'notes')) {
                $table->dropColumn('notes');
            }
        });
    }
};
