<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountCode extends Model
{
    protected $primaryKey = 'account_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'account_code',
        'matricule',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'matricule', 'matricule');
    }
}
