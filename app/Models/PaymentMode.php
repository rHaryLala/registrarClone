<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMode extends Model
{
    protected $fillable = ['code', 'name', 'description'];

    public function installments()
    {
        return $this->hasMany(PaymentModeInstallment::class);
    }
}
