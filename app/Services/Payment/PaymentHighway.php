<?php

namespace App\Api\V1\Services\Payment;

use App\Services\Payment\PaymentService;
use PHPUnit\Framework\Exception;

class PaymentHighway implements PaymentService
{
    private $paymentApi;

    public $transactionType;

    /**
     * Request successful.
     */
    const OK = 100;

    /**
     * Authorization failed, unable to create a Debit transaction or Revert failed.
     * For Debit transactions, please initialize a new transaction the next day (in case there was insufficient funds)
     * and/or contact the cardholder.
     * For transaction reverts, please see the status of the transaction with GET /transaction/<id>
     */
    const FAILURE = 200;

    /**
     * Insufficient balance for the revert: A partial revert with an amount greater
     * than the amount left was performed on the transaction.
     */
    const INSUFFICIENT_BALANCE = 211;

    /**
     * Charge/Revert failed due to acquirer or issuer timeout.
     */
    const TIMEOUT = 209;

    /**
     * Transaction already fully reverted: A full amount revert was performed on an already fully reverted transaction.
     */
    const ALREADY_FULLY_REVERTED = 210;

    /**
     * Insufficient balance for the revert: A partial revert with an amount greater than the amount left was performed
     * on the transaction.
     */
    const INSUFFICIENT_BALANCE_FOR_REVERT = 2011;

    /**
     * The transaction was rejected due to suspected fraud.
     */
    const SUSPECTED_FRAUD = 250;

    /**
     * Transaction in progress. Given when there is already a debit transaction being processed with the ID.
     */
    const IN_PROGRESS = 300;

    /**
     * Could not process the transaction, please try again.
     */
    const ERROR = 900;

    /**
     * Invalid input. Detailed information is in the message field.
     */
    const INVALID_INPUT = 901;

    /**
     * Transaction not found. Error is raised if the transaction iD is not found or when the transaction ID is trying
     * to be used for a wrong type of operation.
     */
    const TRANSACTION_NOT_FOUND = 902;

    /**
     * Invalid operation type. Either a credit transaction is performed on a debit ID or vice versa.
     */
    const INVALID_OPERATION = 10;

    /**
     * Unmatched request parameters. Request parameters do not match the previous parameters with the current
     * transaction ID.
     */
    const UNMATCHED_REQUEST_PARAMETERS = 920;

    /**
     * The transaction did not match any of the merchant’s acquirer routing rules and thus is not allowed.
     */
    const ROUTE_NOT_FOUND = 940;

    /**
     * The card is already tokenized with the existing token.
     */
    const CARD_EXISTS = 950;

    /**
     * Permanent failure. Cannot repeat the transaction. Please initialize a new transaction.
     */
    const PERMANENT_FAILURE = 990;

    public function __construct()
    {

    }

    public function tokenize($tokenizationId)
    {
        $response = $this->paymentApi->tokenize($tokenizationId);

        return $response->body;
    }

    public function charge($token, $amount, $currency = 'EUR'): array
    {

    }

    public function initTransaction()
    {

    }

    public function generateFormBuilder($method, $successUrl, $failureUrl, $cancelUrl)
    {

    }

    private function buildHeaders($method, $uri)
    {

    }

    private function generateUTCTimestamp()
    {
        return str_replace('+00:00', 'Z', gmdate('c'));
    }

    private function generateUUID()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    public function getErrorDefinitions(int $errorCode): array
    {
        $errorMessage = config('service-errors.ph.' . $errorCode);
        return ($errorMessage !== null) ? $errorMessage : ['message' => 'Payment failed'];
    }

    public function refund(int $amount, string $transactionId): array
    {

    }
}
