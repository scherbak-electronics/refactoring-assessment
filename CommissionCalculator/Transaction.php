<?php
namespace CommissionCalculator;
class Transaction
{
    public $bin;
    public $amount;
    public $currency;

    public static function createFromJson($json)
    {
        $data = json_decode($json, true);
        $instance = new self();
        $instance->bin = $data['bin'];
        $instance->amount = $data['amount'];
        $instance->currency = $data['currency'];
        return $instance;
    }
}
