<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinancePlanSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['category' => 'A', 'percentage' => '100', 'description' => 'Tout payer', 'payment' => '2017-04-14', 'date_entry' => '2016-04-14 14:00:11', 'type' => 'TYPE_A', 'last_change_user_id' => null, 'last_change_datetime' => '2017-06-28 14:47:51'],
            ['category' => 'B', 'percentage' => '75', 'description' => '75% à payer avant le', 'payment' => '2017-04-14', 'date_entry' => '2016-04-14 14:01:13', 'type' => 'TYPE_B_1', 'last_change_user_id' => null, 'last_change_datetime' => '2017-06-28 14:47:51'],
            ['category' => 'B', 'percentage' => '25', 'description' => '25% à payer avant le', 'payment' => '2017-07-12', 'date_entry' => '2016-04-14 14:01:35', 'type' => 'TYPE_B_2', 'last_change_user_id' => null, 'last_change_datetime' => '2017-06-28 14:47:51'],
            ['category' => 'C', 'percentage' => '50', 'description' => '50% à payer avant le', 'payment' => '2017-04-14', 'date_entry' => '2016-04-14 14:01:51', 'type' => 'TYPE_C_1', 'last_change_user_id' => null, 'last_change_datetime' => '2017-06-28 14:47:51'],
            ['category' => 'C', 'percentage' => '50', 'description' => '50% à payer avant le', 'payment' => '2017-07-12', 'date_entry' => '2016-04-14 14:02:32', 'type' => 'TYPE_C_2', 'last_change_user_id' => null, 'last_change_datetime' => '2017-06-28 14:47:51'],
            ['category' => 'D', 'percentage' => '40', 'description' => '40% à payer avant le', 'payment' => '2017-04-14', 'date_entry' => '2016-04-14 14:02:50', 'type' => 'TYPE_D_1', 'last_change_user_id' => null, 'last_change_datetime' => '2017-06-28 14:47:51'],
            ['category' => 'D', 'percentage' => '30', 'description' => '30% à payer avant le', 'payment' => '2017-06-14', 'date_entry' => '2016-04-14 14:03:09', 'type' => 'TYPE_D_2', 'last_change_user_id' => null, 'last_change_datetime' => '2017-06-28 14:47:51'],
            ['category' => 'D', 'percentage' => '30', 'description' => '30% à payer avant le', 'payment' => '2017-07-12', 'date_entry' => '2016-04-14 14:03:27', 'type' => 'TYPE_D_3', 'last_change_user_id' => null, 'last_change_datetime' => '2017-06-28 14:47:51'],
            ['category' => 'E', 'percentage' => '25', 'description' => '25% à payer avant le', 'payment' => '2017-04-14', 'date_entry' => '2016-04-14 14:03:48', 'type' => 'TYPE_E_1', 'last_change_user_id' => null, 'last_change_datetime' => '2017-06-28 14:47:51'],
            ['category' => 'E', 'percentage' => '25', 'description' => 'le deuxième tranche 25% à payer avant le', 'payment' => '2017-05-14', 'date_entry' => '2016-04-14 14:04:26', 'type' => 'TYPE_E_2', 'last_change_user_id' => null, 'last_change_datetime' => '2017-06-28 14:47:51'],
            ['category' => 'E', 'percentage' => '25', 'description' => 'le troisième tranche 25% à payer avant le', 'payment' => '2017-06-14', 'date_entry' => '2016-04-14 14:04:49', 'type' => 'TYPE_E_3', 'last_change_user_id' => null, 'last_change_datetime' => '2017-06-28 14:47:51'],
            ['category' => 'E', 'percentage' => '25', 'description' => 'le quatrième tranche à payer avant le ', 'payment' => '2017-07-12', 'date_entry' => '2016-04-14 14:05:16', 'type' => 'TYPE_E_4', 'last_change_user_id' => null, 'last_change_datetime' => '2017-06-28 14:47:51'],
            ['category' => 'F', 'percentage' => '0', 'description' => 'Négociation', 'payment' => '2016-04-14', 'date_entry' => '2016-04-14 14:05:31', 'type' => 'TYPE_F', 'last_change_user_id' => null, 'last_change_datetime' => '2017-06-28 14:47:51'],
        ];

        // Use upsert so running the seeder multiple times won't create duplicates.
        // 'type' values are unique in these rows (TYPE_A, TYPE_B_1, ...), so
        // use it as the conflict key for upsert.
        DB::table('finance_plan')->upsert(
            $rows,
            ['type'], // unique by type
            ['category', 'percentage', 'description', 'payment', 'date_entry', 'last_change_user_id', 'last_change_datetime']
        );
    }
}
