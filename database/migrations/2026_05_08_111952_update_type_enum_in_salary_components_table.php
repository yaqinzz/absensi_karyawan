<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fix salary_components: earning -> allowance
        DB::statement("UPDATE salary_components SET type = 'allowance' WHERE type = 'earning'");
        DB::statement("ALTER TABLE salary_components MODIFY COLUMN type ENUM('allowance', 'deduction') NOT NULL");

        // Fix payroll_items: earning -> allowance
        DB::statement("UPDATE payroll_items SET type = 'allowance' WHERE type = 'earning'");
        DB::statement("ALTER TABLE payroll_items MODIFY COLUMN type ENUM('allowance', 'deduction') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("UPDATE salary_components SET type = 'earning' WHERE type = 'allowance'");
        DB::statement("ALTER TABLE salary_components MODIFY COLUMN type ENUM('earning', 'deduction') NOT NULL");

        DB::statement("UPDATE payroll_items SET type = 'earning' WHERE type = 'allowance'");
        DB::statement("ALTER TABLE payroll_items MODIFY COLUMN type ENUM('earning', 'deduction') NOT NULL");
    }
};
