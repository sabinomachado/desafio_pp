<?php

namespace App\Observers;

use App\Models\Payment;
use Illuminate\Support\Str;

class PaymentObserver
{
    public function creating(Payment $payment)
    {
        $payment->id = Str::uuid();
    }
}
