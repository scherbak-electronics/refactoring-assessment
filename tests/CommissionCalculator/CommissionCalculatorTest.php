<?php

namespace Tests\CommissionCalculator;

use PHPUnit\Framework\TestCase;
use CommissionCalculator\Transaction;
use CommissionCalculator\CommissionCalculator;
use Api\CurrencyServiceInterface;
use Api\BinServiceInterface;

class CommissionCalculatorTest extends TestCase
{
    private $currencyServiceMock;
    private $binServiceMock;
    private $calculator;

    protected function setUp(): void
    {
        // Create mock objects for CurrencyServiceInterface and BinServiceInterface
        $this->currencyServiceMock = $this->createMock(CurrencyServiceInterface::class);
        $this->binServiceMock = $this->createMock(BinServiceInterface::class);

        // Create instance of CommissionCalculator with mocked services
        $this->calculator = new CommissionCalculator($this->currencyServiceMock, $this->binServiceMock);
    }

    public function testCalculate()
    {
        // JSON input for creating a Transaction instance
        $jsonInput = '{"bin":"45717360","amount":"100.00","currency":"EUR"}';

        // Configure the stubs
        $this->currencyServiceMock->method('getRate')->willReturn(1.0); // Assuming EUR to EUR conversion is 1:1
        $this->binServiceMock->method('isEu')->willReturn(true); // Assuming the BIN is from an EU country

        // Create a Transaction instance using the static method from Transaction class
        $transaction = Transaction::createFromJson($jsonInput);

        // Assert the calculated commission
        $expectedCommission = ceil(100.00 * 0.01 * 100) / 100; // Calculate expected commission
        $this->assertEquals($expectedCommission, $this->calculator->calculate($transaction));
    }
}
