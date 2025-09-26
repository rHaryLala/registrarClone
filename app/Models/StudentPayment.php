<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    protected $fillable = ['student_id', 'academic_fee_id', 'amount', 'method', 'reference', 'paid_at'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function academicFee()
    {
        return $this->belongsTo(AcademicFee::class);
    }
}
