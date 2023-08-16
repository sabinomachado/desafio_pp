<?php

namespace App\Services;

interface PaymentServiceInterface
{
    public function makePayment(array $data);
}