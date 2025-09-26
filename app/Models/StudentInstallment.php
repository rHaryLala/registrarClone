<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentInstallment extends Model
{
    protected $fillable = [
        'student_id', 'payment_mode_id', 'academic_fee_id', 'sequence', 'amount_due', 'amount_paid', 'due_at', 'paid_at', 'status', 'reference'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function paymentMode()
    {
        return $this->belongsTo(PaymentMode::class);
    }

    public function academicFee()
    {
        return $this->belongsTo(AcademicFee::class);
    }
}
