<?php

namespace Ticketpark\v11\Record\TransactionCode;

/**
 * TransactionCode
 *
 * For more information on the individual parameters see
 * page 17 in Resources/docs/specifications/zkb-vesr-handbuch.pdf
 */
class TransactionCodeV4 implements TransactionCodeInterface
{
    private $transactioncode = '';
    private $transactiontype = '';
    private $transactionpayment = '';
    private $receipttype = '';

    public function __construct($code, $type, $payment)
    {
        $this->transactioncode = $code . $type;

        if (in_array($code, array('01', '02', '03', '21', '23'))) {
            $this->receipttype = 'esr';
        }elseif (in_array($code, array('11', '13', '31', '33'))) {
            $this->receipttype = 'esr+';
        }else{
            // invalid
            return null;
        }

        if ($type == '1') {
            $this->transactiontype = 'credit';
        }elseif ($type == '2') {
            $this->transactiontype = 'storno';
        }elseif ($type == '3') {
            $this->transactiontype = 'correction';
        }else{
            // invalid
            return null;
        }

        if ($payment == '1') {
            $this->transactionpayment = 'post';
        }elseif ($payment == '2') {
            $this->transactionpayment = 'ZAG/DAG';
        }elseif ($payment == '3') {
            $this->transactionpayment = 'bank';
        }elseif ($payment == '4') {
            $this->transactionpayment = 'euroSIC';
        }else{
            // invalid
            return null;
        }

        return $this;
    }

    public function getTransactionCode()
    {
        return $this->transactioncode;
    }

    public function getTransactionType()
    {
        return $this->transactiontype;
    }

    public function getReceiptType()
    {
        return $this->receipttype;
    }

    public function getPaymentType()
    {
        return $this->transactionpayment;
    }
}
