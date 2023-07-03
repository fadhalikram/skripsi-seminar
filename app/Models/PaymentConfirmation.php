<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentConfirmation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'registration_id',
        'payment_method',
        'amount',
        'description',
        'payment_date',
        'proof_image',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
