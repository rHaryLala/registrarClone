<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $tables = ['students', 'courses', 'mentions', 'teachers'];

        foreach ($tables as $table) {
            if (!Schema::hasTable($table)) {
                continue;
            }

            if (!Schema::hasColumn($table, 'last_change_user_id')) {
                continue;
            }

            Schema::table($table, function (Blueprint $table) {
                $table->foreign('last_change_user_id')->references('id')->on('users')->onDelete('set null');
            });
        }
    }

    public function down()
    {
        $tables = ['students', 'courses', 'mentions', 'teachers'];

        foreach ($tables as $tbl) {
            if (!Schema::hasTable($tbl)) {
                continue;
            }

            if (!Schema::hasColumn($tbl, 'last_change_user_id')) {
                continue;
            }

            Schema::table($tbl, function (Blueprint $table) use ($tbl) {
                $table->dropForeign([$tbl . '_last_change_user_id_foreign']);
            });
        }
    }
};
