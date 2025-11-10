<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Alter using raw SQL to force cast
        DB::statement('ALTER TABLE patients ALTER COLUMN result TYPE jsonb USING result::jsonb');
    }

    public function down(): void
    {
        // Revert back to text if rollback
        DB::statement('ALTER TABLE patients ALTER COLUMN result TYPE text USING result::text');
    }
};
