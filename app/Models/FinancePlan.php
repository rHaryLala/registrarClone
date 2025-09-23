<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancePlan extends Model
{
    // Table name
    protected $table = 'finance_plan';

    // No default timestamps (migration uses date_entry, last_change_datetime)
    public $timestamps = false;

    // Mass assignable
    protected $guarded = [];

    // Casts
    protected $casts = [
        'payment' => 'date',
        'date_entry' => 'datetime',
        'last_change_datetime' => 'datetime',
    ];
}
