<?php

namespace Ticketpark\v11\Record\TransactionCode;

/**
 * TransactionCode
 *
 * For more information on the individual parameters see
 * page 17 in Resources/docs/specifications/zkb-vesr-handbuch.pdf
 */
abstract class TransactionCode implements TransactionCodeInterface
{
    public function getTransactionCode()
    {
        return static::TRANSACTION_CODE;
    }

    public function getTransactionType()
    {
        return static::TRANSACTION_TYPE;
    }

    public function getReceiptType()
    {
        return static::RECEIPT_TYPE;
    }

    public function getPaymentType()
    {
        return static::PAYMENT_TYPE;
    }
}
