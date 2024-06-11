<?php
namespace Services;

use Api\CurrencyServiceInterface;

class CurrencyService implements CurrencyServiceInterface
{
    private $httpClient;

    public function __construct($httpClient = null)
    {
        $this->httpClient = $httpClient ?? function($url) {
            return file_get_contents($url);
        };
    }

    public function getRate($currency)
    {
        $url = 'https://api.exchangeratesapi.io/latest';
        $response = json_decode(($this->httpClient)($url), true);
        return $response['rates'][$currency] ?? 0;
    }
}
