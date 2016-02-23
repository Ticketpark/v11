<?php

namespace Ticketpark\v11\Record;

use Ticketpark\v11\Record\TransactionCode\TransactionCodeInterface;

/**
 * TransactionRecord
 *
 * For more information on the individual parameters see
 * page 23 in Resources/docs/specifications/zkb-vesr-handbuch.pdf
 */
class TransactionRecord
{
    protected $transactionCode;
    protected $participantIdentifier;
    protected $bankingAccount;
    protected $referenceNumber;
    protected $amount;
    protected $internalBankReference;
    protected $datePaid;
    protected $dateProcessed;
    protected $dateCreditNote;
    protected $microfilmReference;
    protected $rejectCode;
    protected $dateValuta;
    protected $fee;

    public function setTransactionCode(TransactionCodeInterface $transactionCode)
    {
        $this->transactionCode = $transactionCode;

        return $this;
    }

    public function getTransactionCode()
    {
        return $this->transactionCode;
    }

    public function setParticipantIdentifier($participantIdentifier)
    {
        $this->participantIdentifier = $participantIdentifier;

        return $this;
    }

    public function getParticipantIdentifier()
    {
        return $this->participantIdentifier;
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

    public function setReferenceNumber($referenceNumber)
    {
        $this->referenceNumber = $referenceNumber;

        return $this;
    }

    public function getReferenceNumber()
    {
        return $this->referenceNumber;
    }

    public function getReferenceNumberWithoutCheckDigit()
    {
        return substr($this->referenceNumber, 0, -1);
    }

    public function getCustomReferenceNumber()
    {
        return substr($this->getReferenceNumberWithoutCheckDigit(), strlen($this->getParticipantIdentifier()));
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

    public function getSignedAmount()
    {
        if ($this->getTransactionCode()->getTransactionType() == 'storno') {

            return $this->amount * -1;
        }

        return $this->amount;
    }

    public function setInternalBankReference($internalBankReference)
    {
        $this->internalBankReference = $internalBankReference;

        return $this;
    }

    public function getInternalBankReference()
    {
        return $this->internalBankReference;
    }

    public function setDatePaid(\DateTime $datePaid = null)
    {
        $this->datePaid = $datePaid;

        return $this;
    }

    public function getDatePaid()
    {
        return $this->datePaid;
    }

    public function setDateProcessed(\DateTime $dateProcessed = null)
    {
        $this->dateProcessed = $dateProcessed;

        return $this;
    }

    public function getDateProcessed()
    {
        return $this->dateProcessed;
    }

    public function setDateCreditNote(\DateTime $dateCreditNote = null)
    {
        $this->dateCreditNote = $dateCreditNote;

        return $this;
    }

    public function getDateCreditNote()
    {
        return $this->dateCreditNote;
    }

    public function setMicrofilmReference($microfilmReference)
    {
        $this->microfilmReference = $microfilmReference;

        return $this;
    }

    public function getMicrofilmReference()
    {
        return $this->microfilmReference;
    }

    public function setRejectCode($rejectCode)
    {
        $this->rejectCode = $rejectCode;

        return $this;
    }

    public function getRejectCode()
    {
        return $this->rejectCode;
    }

    public function setDateValuta(\DateTime $dateValuta = null)
    {
        $this->dateValuta = $dateValuta;

        return $this;
    }

    public function getDateValuta()
    {
        return $this->dateValuta;
    }

    public function setFee($fee)
    {
        $this->fee = $fee;

        return $this;
    }

    public function getFee()
    {
        return $this->fee;
    }
}