<?php

namespace Services;

use Api\CurrencyServiceInterface;
use Symfony\Component\Dotenv\Dotenv;

class CurrencyService implements CurrencyServiceInterface
{
    private $baseUrl;
    private $apiKey;

    public function __construct()
    {
        // Initialize Dotenv and load .env file
        $dotenv = new Dotenv();
        $dotenv->usePutenv()->load(PROJECT_ROOT . '/.env'); // Adjust the path to your .env file if necessary

        // Retrieve the API URL and API key from environment variables
        $this->baseUrl = getenv('CURRENCY_API_URL') ?: 'https://api.exchangeratesapi.io/latest';
        $this->apiKey = getenv('CURRENCY_API_KEY') ?: '';
    }

    public function getRate($currency)
    {
        // Construct the URL with the API key if necessary
        $url = $this->baseUrl . (empty($this->apiKey) ? '' : '?access_key=' . $this->apiKey);
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        // Check if the rate is returned and handle the case where it's zero
        if (!isset($data['rates'][$currency]) || $data['rates'][$currency] == 0) {
            throw new \Exception("No valid rate found for currency: {$currency}");
        }

        return $data['rates'][$currency];
    }
}
