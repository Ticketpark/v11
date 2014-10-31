<?php

namespace Ticketpark\v11\Record\TransactionCode;

class TransactionCodeFactory
{
    public static function create($transactionCode)
    {
        $className = __NAMESPACE__ . '\TransactionCode' . $transactionCode;

        if (!class_exists($className)) {

            return false;
        }

        return new $className();
    }
}