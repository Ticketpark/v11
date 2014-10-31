<?php

include '../vendor/autoload.php';

$v11 = new \Ticketpark\v11\v11();

// Set your esr participant identifier (Teilnehmernummer)
// This is optional, but will be useful to call $record->getCustomReferenceNumber() later on.
$v11->setParticipantIdentifier('123456');

// Set content - by file or array
#$v11->setFile('/path/to/file/besr.v11');
$v11->setLines(array(
    "002012000002123456000000001291146290519      7500000000000014102414102414102400000000000000000000000",
    "012012000002123456000000001290507716881      50000008  000014102314102414102400552073900000000000120",
    "002012000002123456000000001288602003992      2550000000000014102414102414102400000000000000000000000",
    "002012000002123456000000001290068583973      50000008  000014102314102414102400489435900000000000000",
    "999012000002999999999999999999999999999000000020050000000000004141027000000120000000004             ",
));

// Validate the contents
if(!$v11->validate()) {
    print $v11->getError();
}

// Get the transaction records - see Ticketpark\v11\Record\TransactionRecord for more methods
foreach($v11->getTransactionRecords() as $record){
    var_dump(
        array(
            'Transaction type' => $record->getTransactionCode()->getTransactionType(),
            'Payment type' => $record->getTransactionCode()->getPaymentType(),
            'Amount' => $record->getSignedAmount(),
            'Full Reference number' => $record->getReferenceNumber(),
            'Customer numeric reference number' => $record->getCustomReferenceNumber(true),
            'Fee' => $record->getFee(),
        )
    );
}

// Get the total record - see Ticketpark\v11\Record\TotalRecord for more methods
$total = $v11->getTotalRecord();
var_dump(
    array(
        'Transaction type' => $total->getTransactionCode()->getTransactionType(),
        'Amount' => $total->getSignedAmount(),
        'Number of transactions' => $total->getNumberOfTransactions(),
        'Total Fees' => $total->getTotalFees(),
    )
);
