<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Mention;

class Parcours extends Model
{
    protected $fillable = ['nom', 'mention_id'];

    public function mention()
    {
        return $this->belongsTo(Mention::class);
    }
}
