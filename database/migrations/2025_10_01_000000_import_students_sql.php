<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations: import INSERT INTO `students` statements found in database/imports/students.sql
     */
    public function up(): void
    {
        $path = database_path('imports/students.sql');

        if (!File::exists($path)) {
            // nothing to import
            return;
        }

        $sql = File::get($path);

        // Extract all INSERT INTO `students` ...; statements (multi-line, case-insensitive)
        preg_match_all('/INSERT\s+INTO\s+`students`\s.*?;/si', $sql, $matches);

        if (empty($matches[0])) {
            return;
        }

        // Execute statements in a transaction, disable foreign key checks while importing
        DB::transaction(function () use ($matches) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            foreach ($matches[0] as $stmt) {
                // convert to INSERT IGNORE to avoid duplicate-key failures if some rows already exist
                $stmt = preg_replace('/INSERT\s+INTO\s+`students`/i', 'INSERT IGNORE INTO `students`', $stmt, 1);

                // run raw SQL
                DB::unprepared($stmt);
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * Note: rollback is intentionally empty because removing imported rows automatically is risky.
     * If you want rollback behavior, implement selective deletion here (e.g. delete by id range or backup).
     */
    public function down(): void
    {
        // no automatic rollback
    }
};
