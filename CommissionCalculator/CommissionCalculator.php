<?php
namespace CommissionCalculator;

use Api\BinServiceInterface;
use Api\CurrencyServiceInterface;

class CommissionCalculator
{
    private $currencyService;
    private $binService;

    public function __construct(CurrencyServiceInterface $currencyService, BinServiceInterface $binService)
    {
        $this->currencyService = $currencyService;
        $this->binService = $binService;
    }

    public function calculate(Transaction $transaction)
    {
        $rate = $this->currencyService->getRate($transaction->currency);
        $isEu = $this->binService->isEu($transaction->bin);
        $amount = $transaction->amount / $rate;
        return ceil($amount * ($isEu ? 0.01 : 0.02) * 100) / 100;
    }
}
