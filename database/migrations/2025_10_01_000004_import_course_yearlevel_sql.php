<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * This migration will import INSERT statements from database/imports/course_yearlevel.sql
     * and execute them as INSERT IGNORE to avoid duplicate key errors.
     */
    public function up(): void
    {
        DB::transaction(function () {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            $path = database_path('imports/course_yearlevel.sql');
            if (!file_exists($path)) {
                return;
            }
            $content = file_get_contents($path);
            if ($content === false) {
                return;
            }

            // Extract INSERT INTO `course_yearlevel` ...; blocks
            if (preg_match_all('/INSERT\s+INTO\s+`?course_yearlevel`?\s+.*?;/is', $content, $matches)) {
                foreach ($matches[0] as $insertSql) {
                    // Convert to INSERT IGNORE for idempotence
                    $insertSql = preg_replace('/INSERT\s+INTO/i', 'INSERT IGNORE INTO', $insertSql, 1);
                    DB::unprepared($insertSql);
                }
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // no-op
    }
};
