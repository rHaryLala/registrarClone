<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicFee extends Model
{
    protected $fillable = [
        'fee_type_id', 'mention_id', 'level', 'year_level_id', 'academic_year', 'academic_year_id', 'semester', 'semester_id', 'amount', 'notes'
    ];

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }

    public function mention()
    {
        return $this->belongsTo(Mention::class);
    }

    public function yearLevel()
    {
        return $this->belongsTo(YearLevel::class, 'year_level_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}
