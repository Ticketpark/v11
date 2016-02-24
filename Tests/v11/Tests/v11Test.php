<?php

namespace Ticketpark\v11\Tests;

use Ticketpark\v11\v11;

class v11Test extends \PHPUnit_Framework_TestCase
{
    public function testValidate()
    {
        $v11 = new v11(array(
            "002012000002123456000000001291146290519      7500000000000014102414102414102400000000000000000000000",
            "012012000002123456000000001290507716881      50000008  000014102314102414102400552073900000000000120",
            "002012000002123456000000001288602003992      2550000000000014102414102414102400000000000000000000000",
            "002012000002123456000000001290068583973      50000008  000014102314102414102400489435900000000000000",
            "999012000002999999999999999999999999999000000020050000000000004141027000000120000000004             ",
        ));
        $this->assertTrue($v11->validate());
    }

    public function testValidateTransactions()
    {
        $v11 = new v11(array(
            "002012000002123456000000001291146290519      7500000000000014102414102514102600000000000000000000120",
            "012012000002123456000000001290507716881      50000008  000014102314102414102400552073900000000000000",
            "002012000002123456000000001288602003992      2550000000000014102414102414102400000000000000000000000",
            "002012000002123456000000001290068583973      50000008  000014102314102414102400489435900000000000000",
            "999012000002999999999999999999999999999000000020050000000000004141027000000120000000004             ",
        ));
        $v11->setParticipantIdentifier('123456');

        $this->assertSame('002', $v11->getTransactionRecords()[0]->getTransactionCode()->getTransactionCode());
        $this->assertSame('credit', $v11->getTransactionRecords()[0]->getTransactionCode()->getTransactionType());
        $this->assertSame('esr', $v11->getTransactionRecords()[0]->getTransactionCode()->getReceiptType());
        $this->assertSame('banking', $v11->getTransactionRecords()[0]->getTransactionCode()->getPaymentType());

        $this->assertSame('012000002', $v11->getTransactionRecords()[0]->getBankingAccount());
        $this->assertSame('123456000000001291146290519', $v11->getTransactionRecords()[0]->getReferenceNumber());
        $this->assertSame('12345600000000129114629051', $v11->getTransactionRecords()[0]->getReferenceNumberWithoutCheckDigit());
        $this->assertSame('00000000129114629051', $v11->getTransactionRecords()[0]->getCustomReferenceNumber());
        $this->assertSame(75, $v11->getTransactionRecords()[0]->getAmount());
        $this->assertSame('0000000000', $v11->getTransactionRecords()[0]->getInternalBankReference());
        $this->assertSame('2014-10-24', $v11->getTransactionRecords()[0]->getDatePaid()->format('Y-m-d'));
        $this->assertSame('2014-10-25', $v11->getTransactionRecords()[0]->getDateProcessed()->format('Y-m-d'));
        $this->assertSame('2014-10-26', $v11->getTransactionRecords()[0]->getDateCreditNote()->format('Y-m-d'));
        $this->assertSame('000000000', $v11->getTransactionRecords()[0]->getMicrofilmReference());
        $this->assertSame('0', $v11->getTransactionRecords()[0]->getRejectCode());
        $this->assertNull($v11->getTransactionRecords()[0]->getDateValuta());
        $this->assertSame(1.2, $v11->getTransactionRecords()[0]->getFee());

        $this->assertSame('999', $v11->getTotalRecord()->getTransactionCode()->getTransactionCode());
        $this->assertSame('012000002', $v11->getTotalRecord()->getBankingAccount());
        $this->assertSame('999999999999999999999999999', $v11->getTotalRecord()->getSortingKey());
        $this->assertSame(4, $v11->getTotalRecord()->getNumberOfTransactions());
        $this->assertSame('2014-10-27', $v11->getTotalRecord()->getDateFileCreation()->format('Y-m-d'));
        $this->assertSame(1.2, $v11->getTotalRecord()->getTotalFees());
    }


    public function testValidateTotalLineTooShort()
    {
        $v11 = new v11(array(
            "002012000002123456000000001291146290519      7500000000000014102414102414102400000000000000000000000",
            "012012000002123456000000001290507716881      50000008  000014102314102414102400552073900000000000120",
            "002012000002123456000000001288602003992      2550000000000014102414102414102400000000000000000000000",
            "002012000002123456000000001290068583973      50000008  000014102314102414102400489435900000000000000",
            "99901200000299999999999999999999999999900000020050000000000004141027000000120000000004             ",
        ));
        $this->assertFalse($v11->validate());
        $this->assertSame('The total line contains 86 instead of 87 characters', $v11->getError());
    }

    public function testValidateTotalLineBadTransactionCode()
    {
        $v11 = new v11(array(
            "002012000002123456000000001291146290519      7500000000000014102414102414102400000000000000000000000",
            "012012000002123456000000001290507716881      50000008  000014102314102414102400552073900000000000120",
            "002012000002123456000000001288602003992      2550000000000014102414102414102400000000000000000000000",
            "002012000002123456000000001290068583973      50000008  000014102314102414102400489435900000000000000",
            "111012000002999999999999999999999999999000000020050000000000004141027000000120000000004             ",
        ));
        $this->assertFalse($v11->validate());
        $this->assertSame('The total line does not contain a valid transaction code', $v11->getError());
    }

    public function testValidateTotalLineInvalidContents()
    {
        $v11 = new v11(array(
            "002012000002123456000000001291146290519      7500000000000014102414102414102400000000000000000000000",
            "012012000002123456000000001290507716881      50000008  000014102314102414102400552073900000000000120",
            "002012000002123456000000001288602003992      2550000000000014102414102414102400000000000000000000000",
            "002012000002123456000000001290068583973      50000008  000014102314102414102400489435900000000000000",
            "99901200000299999999999999999999999999900A000020050000000000004141027000000120000000004             ",
        ));
        $this->assertFalse($v11->validate());
        $this->assertSame('The total line contains invalid characters. It may only contain digits and spaces', $v11->getError());
    }

    public function testValidateTransactionLineTooShort()
    {
        $v11 = new v11(array(
            "002012000002123456000000001291146290519      7500000000000014102414102414102400000000000000000000000",
            "012012000002123456000000001290507716881      50000008  000014102314102414102400552073900000000000120",
            "002012000002123456000000001288602003992      255000000000001410241410241410240000000000000000000000",
            "002012000002123456000000001290068583973      50000008  000014102314102414102400489435900000000000000",
            "999012000002999999999999999999999999999000000020050000000000004141027000000120000000004             ",
        ));
        $this->assertFalse($v11->validate());
        $this->assertSame('Line number 3 contains 99 instead of 100 characters', $v11->getError());
    }

    public function testValidateTransactionLineBadTransactionCode()
    {
        $v11 = new v11(array(
            "002012000002123456000000001291146290519      7500000000000014102414102414102400000000000000000000000",
            "012012000002123456000000001290507716881      50000008  000014102314102414102400552073900000000000120",
            "007012000002123456000000001288602003992      2550000000000014102414102414102400000000000000000000000",
            "002012000002123456000000001290068583973      50000008  000014102314102414102400489435900000000000000",
            "999012000002999999999999999999999999999000000020050000000000004141027000000120000000004             ",
        ));
        $this->assertFalse($v11->validate());
        $this->assertSame('Line number 3 contains does not contain a valid transaction code', $v11->getError());
    }

    public function testValidateTransactionLineInvalidContents()
    {
        $v11 = new v11(array(
            "002012000002123456000000001291146290519      7500000000000014102414102414102400000000000000000000000",
            "012012000002123456000000001290507716881      50000008  000014102314102414102400552073900000000000120",
            "002012000002123456000000001288602003992      255000000A000014102414102414102400000000000000000000000",
            "002012000002123456000000001290068583973      50000008  000014102314102414102400489435900000000000000",
            "999012000002999999999999999999999999999000000020050000000000004141027000000120000000004             ",
        ));
        $this->assertFalse($v11->validate());
        $this->assertSame('Line number 3 contains invalid characters. It may only contain digits and spaces', $v11->getError());
    }

    public function testValidateNotMatchingNumberOfTransactions()
    {
        $v11 = new v11(array(
            "002012000002123456000000001291146290519      7500000000000014102414102414102400000000000000000000000",
            "012012000002123456000000001290507716881      50000008  000014102314102414102400552073900000000000120",
            "002012000002123456000000001290068583973      50000008  000014102314102414102400489435900000000000000",
            "999012000002999999999999999999999999999000000020050000000000004141027000000120000000004             ",
        ));
        $this->assertFalse($v11->validate());
        $this->assertSame('The number of 3 transactions does not match the number of 4 transactions according to the total line', $v11->getError());
    }
}
