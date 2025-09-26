<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicFee;
use App\Models\FeeType;
use App\Models\YearLevel;
use App\Models\AcademicYear;
use App\Models\Semester;
use App\Models\Mention;
use Illuminate\Support\Str;

class AcademicFeeSeeder extends Seeder
{
    public function run()
    {
        // Build academic fees for every mention × year level × fee type
        $feeTypes = FeeType::all();
        $mentions = Mention::all();
        $yearLevels = YearLevel::all();

        // Choose the active academic year only. If none exists, skip seeding here.
        $academicYear = AcademicYear::where('active', true)->first();
        if (!$academicYear) {
            if ($this->command) {
                $this->command->info('AcademicFeeSeeder: no active academic year found, skipping AcademicFee seeding.');
            }
            return;
        }

        // Ensure we have a semester for that academic year
        $semester = Semester::where('academic_year_id', $academicYear->id)->orderBy('ordre')->first();
        if (!$semester) {
            $semester = Semester::firstOrCreate(['nom' => 'S1', 'ordre' => 1, 'academic_year_id' => $academicYear->id], ['date_debut' => now(), 'date_fin' => now()->addMonths(6)]);
        }

        // Default amount mapping for common fee types
        $amountMatrix = [
            'Frais Généraux' => [
                'L1R' => [ 'default' => 250000 ],
                'L1' => [ 'default' => 250000 ],
                'L2' => [ 'default' => 250000 ],
                'L3' => [ 'default' => 250000 ],
                'M1' => [ 'default' => 230000 ],
                'M2' => [ 'default' => 230000 ],
                'default' => [ 'default' => 250000 ],
            ],
            'Écolage' => [
                'L1' => [ 'default' => 19000 ],
                'L2' => [ 'default' => 19000 ],
                'L3' => [ 'default' => 19000 ],
                'M1' => [ 'default' => 25000 ],
                'M2' => [ 'default' => 25000 ],
                'default' => [ 'default' => 19000 ],
            ],
            'Cantine' => [ 'default' => [ 'default' => 8000 ] ],
            'Dortoir' => [ 'default' => [ 'default' => 3000 ] ],
            'Laboratoire Informatique' => [ 'default' => [ 'default' => 35000 ] ],
            'Laboratoire Communication' => [ 'default' => [ 'default' => 30000 ] ],
            'Laboratoire Langue' => [ 'default' => [ 'default' => 30000 ] ],
            'Voyage d\'etude' => [ 'default' => [ 'default' => 150000 ] ],
            'Colloque' => [ 'default' => [ 'default' => 150000 ] ],
            'Costume' => [ 'default' => [ 'default' => 150000 ] ],
            'Graduation' => [ 'default' => [ 'default' => 150000 ] ],
        ];

        // Normalize helper: remove accents, punctuation and lowercase
        $normalize = function($s) {
            $s = Str::lower($s);
            // remove accents
            $s = Str::ascii($s);
            // remove non-alphanumeric (except spaces)
            $s = preg_replace('/[^a-z0-9\s]/', '', $s);
            // collapse spaces
            $s = preg_replace('/\s+/', ' ', $s);
            return trim($s);
        };

        // Build normalized amount matrix map for faster lookup
        $normalizedMatrix = [];
        foreach ($amountMatrix as $ftName => $byYear) {
            $nft = $normalize($ftName);
            $normalizedMatrix[$nft] = $byYear;
        }

        $defaultAmount = 0; // fallback when not found

        // create fees for all mentions/year levels/fee types
        foreach ($mentions as $mention) {
            foreach ($yearLevels as $yl) {
                foreach ($feeTypes as $ft) {
                    // Resolve amount using normalized matrix: feeType -> yearLevel.code -> mention.nom
                    $amount = $defaultAmount;
                    $ftName = $ft->name;
                    $nftName = $normalize($ftName);
                    $ylCode = $yl->code ?? 'default';
                    $mentionName = $mention->nom ?? 'default';

                    if (isset($normalizedMatrix[$nftName])) {
                        $byYear = $normalizedMatrix[$nftName];
                        // Try several year keys: code, numeric id, then 'default'
                        $yearKeyCandidates = [$ylCode, (string)$yl->id, 'default'];
                        $yearBlock = null;
                        foreach ($yearKeyCandidates as $k) {
                            if (isset($byYear[$k])) {
                                $yearBlock = $byYear[$k];
                                break;
                            }
                        }
                        if ($yearBlock) {
                            // Try mention by name, then by id, then default
                            $mentionKeyCandidates = [$mentionName, (string)$mention->id, 'default'];
                            foreach ($mentionKeyCandidates as $mk) {
                                if (isset($yearBlock[$mk])) {
                                    $amount = $yearBlock[$mk];
                                    break;
                                }
                            }
                        }
                    } else {
                        // not found in matrix — warn once
                        if ($this->command) {
                            $this->command->warn("AcademicFeeSeeder: fee type '" . $ftName . "' not found in amountMatrix, using default amount {$defaultAmount}");
                        }
                    }

                    AcademicFee::firstOrCreate([
                        'fee_type_id' => $ft->id,
                        'mention_id' => $mention->id,
                        'year_level_id' => $yl->id,
                        'academic_year_id' => $academicYear->id,
                        'semester_id' => $semester->id,
                    ], ['amount' => $amount]);
                }
            }
        }
    }
}
