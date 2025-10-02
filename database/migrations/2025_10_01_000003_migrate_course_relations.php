<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration performs three tasks (idempotent where possible):
     * 1. Import INSERT statements from database/imports/course_mention.sql into `course_mention` (if the file exists).
     * 2. Migrate rows from legacy table `course_year_level` into `course_yearlevel` (if the legacy table exists).
     * 3. Attempt to migrate rows from a legacy `course_student` table only when a separate legacy table exists
     *    (to avoid inserting duplicates when the source and destination share the same name).
     *
     * Assumptions:
     * - The SQL file (if present) contains INSERT INTO `course_mention` ...; statements.
     * - The legacy table for year-levels is named `course_year_level` (with underscores) and target table is `course_yearlevel`.
     * - If your legacy course_student data is stored in a different table name (eg. course_student_old), add that table
     *   and this migration will pick it up if present. If the source and target are the same table name, the migration will
     *   skip to avoid duplicate inserts.
     */
    public function up(): void
    {
        // Use a transaction so partial imports won't leave the DB in an inconsistent state.
        DB::transaction(function () {
            // Temporarily disable foreign key checks for import convenience.
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            // 1) Import SQL file for course_mention if present
            $sqlPath = database_path('imports/course_mention.sql');
            if (file_exists($sqlPath)) {
                $content = file_get_contents($sqlPath);
                if ($content !== false) {
                    // Extract INSERT INTO `course_mention` ...; statements and execute them as INSERT IGNORE
                    // so migration can be re-run safely.
                    if (preg_match_all('/INSERT\s+INTO\s+`?course_mention`?\s+.*?;/is', $content, $matches)) {
                        foreach ($matches[0] as $insertSql) {
                            // Convert to INSERT IGNORE for idempotence
                            $insertSql = preg_replace('/INSERT\s+INTO/i', 'INSERT IGNORE INTO', $insertSql, 1);
                            DB::unprepared($insertSql);
                        }
                    }
                }
            }

            // 1a) Import SQL file for courses if present (common project dump)
            $coursesSql = database_path('imports/courses.sql');
            if (file_exists($coursesSql)) {
                $content = file_get_contents($coursesSql);
                if ($content !== false) {
                    // Extract INSERT INTO `courses` ...; statements and execute them as INSERT IGNORE
                    if (preg_match_all('/INSERT\s+INTO\s+`?courses`?\s+.*?;/is', $content, $matches)) {
                        foreach ($matches[0] as $insertSql) {
                            $insertSql = preg_replace('/INSERT\s+INTO/i', 'INSERT IGNORE INTO', $insertSql, 1);
                            DB::unprepared($insertSql);
                        }
                    }
                }
            }

            // 1b) Import SQL for student_semester_fees if present
            $ssfSql = database_path('imports/student_semester_fees.sql');
            if (file_exists($ssfSql)) {
                $content = file_get_contents($ssfSql);
                if ($content !== false) {
                    // Extract INSERT INTO `student_semester_fees` ...; and execute as INSERT IGNORE
                    if (preg_match_all('/INSERT\s+INTO\s+`?student_semester_fees`?\s+.*?;/is', $content, $matches)) {
                        foreach ($matches[0] as $insertSql) {
                            $insertSql = preg_replace('/INSERT\s+INTO/i', 'INSERT IGNORE INTO', $insertSql, 1);
                            DB::unprepared($insertSql);
                        }
                    }
                }
            }

            // 1c) Import SQL for finance(s) if present (support both `finance` and `finances` filenames and table names)
            $financeFiles = [database_path('imports/finance.sql'), database_path('imports/finances.sql')];
            foreach ($financeFiles as $fpath) {
                if (!file_exists($fpath)) {
                    continue;
                }
                $content = file_get_contents($fpath);
                if ($content === false) {
                    continue;
                }
                // Try both `finance` and `finances` table patterns
                if (preg_match_all('/INSERT\s+INTO\s+`?(finance|finances)`?\s+.*?;/is', $content, $matches)) {
                    foreach ($matches[0] as $insertSql) {
                        $insertSql = preg_replace('/INSERT\s+INTO/i', 'INSERT IGNORE INTO', $insertSql, 1);
                        DB::unprepared($insertSql);
                    }
                }
            }

            // 1b) Also import course_student SQL snapshot if present (many projects export this as a separate SQL file)
            $courseStudentSql = database_path('imports/course_student.sql');
            if (file_exists($courseStudentSql)) {
                $content = file_get_contents($courseStudentSql);
                if ($content !== false) {
                    // Find INSERT INTO `course_student` ...; statements and execute them with INSERT IGNORE
                    if (preg_match_all('/INSERT\s+INTO\s+`?course_student`?\s+.*?;/is', $content, $matches)) {
                        foreach ($matches[0] as $insertSql) {
                            $insertSql = preg_replace('/INSERT\s+INTO/i', 'INSERT IGNORE INTO', $insertSql, 1);
                            DB::unprepared($insertSql);
                        }
                    }
                }
            }

            // 2) Migrate course_year_level -> course_yearlevel if legacy table exists
            if (Schema::hasTable('course_year_level') && Schema::hasTable('course_yearlevel')) {
                // Pull distinct pairs to avoid duplicates
                $rows = DB::table('course_year_level')
                    ->select('course_id', 'year_level_id', 'created_at', 'updated_at')
                    ->distinct()
                    ->get();

                foreach ($rows as $row) {
                    // insertOrIgnore will respect unique constraint on (course_id, year_level_id)
                    DB::table('course_yearlevel')->insertOrIgnore([
                        'course_id' => $row->course_id,
                        'year_level_id' => $row->year_level_id,
                        'created_at' => $row->created_at ?? now(),
                        'updated_at' => $row->updated_at ?? now(),
                    ]);
                }
            }

            // 3) Migrate course_student legacy data
            // If there exists a legacy table with a different name that holds the source data, list common candidates.
            $candidateNames = ['course_student_old', 'course_student_legacy', 'course_student_backup'];
            $migrated = false;

            foreach ($candidateNames as $candidate) {
                if (Schema::hasTable($candidate) && Schema::hasTable('course_student')) {
                    $rows = DB::table($candidate)
                        ->select('course_id', 'student_id', 'added_at', 'deleted_at', 'created_at', 'updated_at')
                        ->distinct()
                        ->get();

                    foreach ($rows as $row) {
                        DB::table('course_student')->insertOrIgnore([
                            'course_id' => $row->course_id,
                            'student_id' => $row->student_id,
                            'added_at' => $row->added_at,
                            'deleted_at' => $row->deleted_at,
                            'created_at' => $row->created_at ?? now(),
                            'updated_at' => $row->updated_at ?? now(),
                        ]);
                    }

                    $migrated = true;
                    break;
                }
            }

            // If no legacy candidate was found but there exists a table named `course_student` only once
            // we avoid copying since source and destination are identical; this prevents duplicates.

            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * Note: we intentionally do not delete imported data because it may be production data. Implementing
     * a safe rollback would require application-specific knowledge about what rows to remove.
     *
     * @return void
     */
    public function down(): void
    {
        // no-op: keep imported data
    }
};
