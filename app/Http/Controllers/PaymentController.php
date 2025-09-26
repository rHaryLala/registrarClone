<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\AcademicFee;
use App\Models\PaymentMode;
use App\Services\InstallmentService;
use Carbon\Carbon;

class PaymentController extends Controller
{
    protected $installmentService;

    public function __construct(InstallmentService $installmentService)
    {
        $this->installmentService = $installmentService;
    }

    // Choose a payment mode for a student and generate installments
    public function choosePaymentMode(Request $request, $studentId)
    {
        $request->validate([
            'payment_mode_code' => 'required|string',
            'academic_fee_id' => 'required|exists:academic_fees,id'
        ]);

        $student = Student::findOrFail($studentId);
        $academicFee = AcademicFee::findOrFail($request->academic_fee_id);
        $paymentMode = PaymentMode::where('code', $request->payment_mode_code)->firstOrFail();

        $startAt = null;
        if ($request->filled('start_at')) {
            $startAt = Carbon::parse($request->input('start_at'));
        }

        $created = $this->installmentService->generateFor($student, $academicFee, $paymentMode, $startAt);

        return redirect()->back()->with('success', 'Échéances générées (' . count($created) . ')');
    }
}
