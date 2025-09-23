<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TracksLastChange;

class Teacher extends Model
{
    use TracksLastChange;

    protected $fillable = [
        'name',
        'email',
        'telephone',
        'diplome',
    ];
}
