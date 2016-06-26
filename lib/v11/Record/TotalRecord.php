<?php

namespace Ticketpark\v11\Record;

use Ticketpark\v11\Record\TransactionCode\TransactionCodeInterface;

/**
 * TotalRecord
 *
 * For more information on the individual parameters see
 * page 24 in Resources/docs/specifications/zkb-vesr-handbuch.pdf
 */
class TotalRecord
{
    protected $transactionCode;
    protected $bankingAccount;
    protected $sortingKey;
    protected $amount;
    protected $currency = 'CHF';
    protected $numberOfTransactions;
    protected $dateFileCreation;
    protected $totalFees;

    public function setTransactionCode(TransactionCodeInterface $transactionCode)
    {
        $this->transactionCode = $transactionCode;

        return $this;
    }

    public function getTransactionCode()
    {
        return $this->transactionCode;
    }

    public function setBankingAccount($bankingAccount)
    {
        $this->bankingAccount = $bankingAccount;

        return $this;
    }

    public function getBankingAccount()
    {
        return $this->bankingAccount;
    }

    public function setSortingKey($sortingKey)
    {
        $this->sortingKey = $sortingKey;

        return $this;
    }

    public function getSortingKey()
    {
        return $this->sortingKey;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getSignedAmount()
    {
        if ($this->getTransactionCode()->getTransactionType() == 'storno') {

            return $this->amount * -1;
        }

        return $this->amount;
    }

    public function setNumberOfTransactions($numberOfTransactions)
    {
        $this->numberOfTransactions = $numberOfTransactions;

        return $this;
    }

    public function getNumberOfTransactions()
    {
        return $this->numberOfTransactions;
    }

    public function setDateFileCreation(\DateTime $dateFileCreation = null)
    {
        $this->dateFileCreation = $dateFileCreation;

        return $this;
    }

    public function getDateFileCreation()
    {
        return $this->dateFileCreation;
    }

    public function setTotalFees($totalFees)
    {
        $this->totalFees = $totalFees;

        return $this;
    }

    public function getTotalFees()
    {
        return $this->totalFees;
    }
}
