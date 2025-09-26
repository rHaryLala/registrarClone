<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentModeInstallment extends Model
{
    protected $fillable = ['payment_mode_id', 'sequence', 'percentage', 'days_after', 'label'];

    public function paymentMode()
    {
        return $this->belongsTo(PaymentMode::class);
    }
}
