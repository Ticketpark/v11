<?php

namespace Ticketpark\v11\Record\TransactionCode;

interface TransactionCodeInterface
{
    public function getTransactionCode();

    public function getTransactionType();

    public function getReceiptType();

    public function getPaymentType();
}