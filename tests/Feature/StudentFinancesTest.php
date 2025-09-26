<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Student;
use App\Models\AcademicFee;
use App\Models\PaymentMode;
use App\Models\PaymentModeInstallment;
use App\Models\StudentInstallment;
use App\Models\FeeType;
use Carbon\Carbon;

class StudentFinancesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // run the seeders that provide payment modes and fee types
        $this->seed(\Database\Seeders\FeeTypeSeeder::class);
        $this->seed(\Database\Seeders\PaymentModeSeeder::class);
    }

    public function test_generate_installments_for_student_from_payment_mode()
    {
        // create a student
        $student = Student::create([
            'nom' => 'Rakoto',
            'prenom' => 'Jean',
            'sexe' => 'M',
            'etat_civil' => 'célibataire',
            'date_naissance' => '2000-01-01',
            'lieu_naissance' => 'Antananarivo',
            'nom_pere' => 'Rakoto Sr',
            'profession_pere' => 'Farmer',
            'contact_pere' => '0320000000',
            'nom_mere' => 'Rabe',
            'profession_mere' => 'Teacher',
            'contact_mere' => '0320000001',
            'adresse_parents' => 'Somewhere',
            'email' => 'test.student@example.com',
            'adresse' => 'Adresse',
            'region' => 'Analamanga',
            'district' => 'Antananarivo',
        ]);

        // create a fee type and an academic fee
        $feeType = FeeType::first();
        $academicFee = AcademicFee::create([
            'fee_type_id' => $feeType->id,
            'mention_id' => null,
            'level' => 'Licence',
            'academic_year' => '2025-2026',
            'semester' => 'Full',
            'amount' => 1000000, // 1,000,000 as base amount
            'notes' => 'Test fee'
        ]);

        // choose payment mode C (the 50/25/25 schedule per your spec)
        $paymentMode = PaymentMode::where('code', 'C')->firstOrFail();

        // call the controller action directly to avoid auth middleware in tests
        $controller = new \App\Http\Controllers\PaymentController(app(\App\Services\InstallmentService::class));
        $request = \Illuminate\Http\Request::create('/fake', 'POST', [
            'payment_mode_code' => 'C',
            'academic_fee_id' => $academicFee->id,
            'start_at' => '2025-10-03'
        ]);

        $response = $controller->choosePaymentMode($request, $student->id);
        $this->assertNotNull($response);

        // reload student installments
        $student->refresh();

        $installments = $student->installments()->orderBy('sequence')->get();
        $this->assertCount(3, $installments);

        // expected amounts based on percentages 50,25,25 of 1,000,000
        $this->assertEquals(500000.00, $installments[0]->amount_due + 0.0);
        $this->assertEquals(250000.00, $installments[1]->amount_due + 0.0);
        $this->assertEquals(250000.00, $installments[2]->amount_due + 0.0);

        // check due dates correspond to the seeded template relative to reference 2025-10-03
        $reference = Carbon::create(2025, 10, 3);
        $modeTemplates = $paymentMode->installments()->orderBy('sequence')->get();
        foreach ($modeTemplates as $i => $tpl) {
            $expectedDue = $reference->copy()->addDays($tpl->days_after)->startOfDay();
            $actualDue = Carbon::parse($installments[$i]->due_at)->startOfDay();
            $this->assertTrue($expectedDue->equalTo($actualDue), "Due date mismatch for sequence {$tpl->sequence}");
        }

        // balance should equal total due
        $this->assertEquals(1000000.00, $student->balance());
    }
}
