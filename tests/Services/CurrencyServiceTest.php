<?php

namespace Tests\Services;

use PHPUnit\Framework\TestCase;
use Services\CurrencyService;

class CurrencyServiceTest extends TestCase
{
    public function testGetRate()
    {
        // Mock HTTP client
        $mockHttpClient = function($url) {
            return json_encode([
                'rates' => [
                    'EUR' => 1,
                    'USD' => 1.2
                ]
            ]);
        };

        // Create instance of CurrencyService with mocked HTTP client
        $service = new CurrencyService($mockHttpClient);

        // Assert that the correct rate is returned
        $this->assertEquals(1, $service->getRate('EUR'));
        $this->assertEquals(1.2, $service->getRate('USD'));
        $this->assertEquals(0, $service->getRate('GBP'));  // GBP rate is not provided in mock, should return 0
    }
}
