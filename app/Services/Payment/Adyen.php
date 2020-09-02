<?php

namespace App\Api\V1\Services\Payment;

use App\Services\Payment\PaymentService;

class Adyen implements PaymentService
{

    /**
     * Request successful.
     */
    const AUTHORISED = 1;

    /**
     * Request successful.
     */
    const REFUSED = 2;


    public function __construct()
    {

    }


    public function charge($token, $amount, $currency = 'EUR', $user = null): array
    {


    }

    public function refund(int $amount, string $transactionId, $currency = 'EUR'): array
    {

    }

    public function getErrorDefinitions(int $errorCode): array
    {
        $errorMessage = config('service-errors.adyen.' . $errorCode);
        return $errorMessage ?? ['message' => 'Payment failed'];
    }
}
