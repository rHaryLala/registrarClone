<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMode;
use App\Models\PaymentModeInstallment;

class PaymentModeSeeder extends Seeder
{
    public function run()
    {
        // We'll use a reference start date (contract/choice date) = 2025-10-03
        // and compute days_after for fixed due dates provided by the user.
        $reference = \Carbon\Carbon::create(2025, 10, 3);

        $modes = [
            ['code' => 'A', 'name' => 'Complet (100%)', 'installments' => [
                ['percentage' => 100, 'due' => '2025-10-03', 'label' => 'Paiement unique']
            ]],
            ['code' => 'B', 'name' => '2x (50% / 50%)', 'installments' => [
                ['percentage' => 50, 'due' => '2025-10-03', 'label' => '1ère moitié'],
                ['percentage' => 50, 'due' => '2026-01-30', 'label' => '2ème moitié']
            ]],
            ['code' => 'C', 'name' => '3x (50% / 25% / 25%)', 'installments' => [
                ['percentage' => 50, 'due' => '2025-10-03', 'label' => '1ère tranche'],
                ['percentage' => 25, 'due' => '2025-12-19', 'label' => '2ème tranche'],
                ['percentage' => 25, 'due' => '2026-01-30', 'label' => '3ème tranche']
            ]],
            ['code' => 'D', 'name' => '75% / 25%', 'installments' => [
                ['percentage' => 75, 'due' => '2025-10-03', 'label' => '1ère tranche'],
                ['percentage' => 25, 'due' => '2026-01-30', 'label' => '2ème tranche']
            ]],
            ['code' => 'E', 'name' => '4x personnalisé', 'installments' => [
                ['percentage' => 25, 'due' => '2025-10-24', 'label' => 'T1'],
                ['percentage' => 25, 'due' => '2025-11-28', 'label' => 'T2'],
                ['percentage' => 25, 'due' => '2025-12-19', 'label' => 'T3'],
                ['percentage' => 25, 'due' => '2026-01-30', 'label' => 'T4']
            ]]
        ];

        foreach ($modes as $m) {
            $mode = PaymentMode::firstOrCreate(['code' => $m['code']], ['name' => $m['name']]);

            $seq = 1;
            foreach ($m['installments'] as $ins) {
                $due = \Carbon\Carbon::parse($ins['due']);
                $daysAfter = $reference->diffInDays($due, false);

                PaymentModeInstallment::firstOrCreate([
                    'payment_mode_id' => $mode->id,
                    'sequence' => $seq
                ], [
                    'percentage' => $ins['percentage'],
                    'days_after' => $daysAfter,
                    'label' => $ins['label']
                ]);

                $seq++;
            }
        }
    }
}
