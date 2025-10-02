<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Import INSERT statements from database/imports/teachers.sql into `teachers` (if present).
     */
    public function up(): void
    {
        DB::transaction(function () {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            $path = database_path('imports/teachers.sql');
            if (!file_exists($path)) {
                return;
            }
            $content = file_get_contents($path);
            if ($content === false) {
                return;
            }

            // Extract INSERT INTO `teachers` ...; statements and run as INSERT IGNORE
            if (preg_match_all('/INSERT\s+INTO\s+`?teachers`?\s+.*?;/is', $content, $matches)) {
                foreach ($matches[0] as $insertSql) {
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
