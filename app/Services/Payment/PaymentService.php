<?php

namespace App\Services\Payment;


interface PaymentService
{

    public function charge($token, $amount, $currency = 'EUR'): array;

    public function refund(int $amount, string $transactionId): array;

    public function getErrorDefinitions(int $code): array;
}
