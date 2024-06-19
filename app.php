<?php
require 'vendor/autoload.php';
const PROJECT_ROOT = __DIR__;
use CommissionCalculator\CommissionCalculator;
use CommissionCalculator\Transaction;
use Services\BinService;
use Services\CurrencyService;

// Main script execution
$transactions = file_get_contents($argv[1]);
$calculator = new CommissionCalculator(new CurrencyService(), new BinService());

foreach (explode("\n", $transactions) as $row) {
    if (empty($row)) break;
    $transaction = Transaction::createFromJson($row);
    echo $calculator->calculate($transaction) . "\n";
}