<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // ✅ Add new columns for doctors
            $table->string('specialization')->nullable()->after('role');
            $table->string('phone')->nullable()->after('specialization');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['specialization', 'phone']);
        });
    }
};
