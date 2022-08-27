<?php

use App\CurrencyConverter;
use PHPUnit\Framework\TestCase;

class CurrencyConverterTest extends TestCase
{
    /**
     * @test
     */
    public function testCorrectCurrency()
    {

        $json =
            '{
                "baseCurrency": "EUR",
                "exchangeRates" : {
                    "EUR": 1,
                    "USD": 5,
                    "CHF": 0.97,
                    "CNY": 2.3
                }
            }';

        $converter = new CurrencyConverter($json);
        $output = $converter->getExchangeRates();
        $this->assertEquals(true, is_array($output));
    }
}
