<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentSemesterFee extends Model
{
    protected $table = 'student_semester_fees';

    protected $fillable = [
        'student_id', 'academic_year_id', 'semester_id',
        'frais_generaux','dortoir','cantine','labo_info','labo_comm','labo_langue','ecolage','voyage_etude','colloque','frais_costume',
        'total_amount','computed_by_user_id','computed_at'
    ];

    protected $casts = [
        'computed_at' => 'datetime'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
