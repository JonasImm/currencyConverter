<?php

use App\CurrencyConverter;
use PHPUnit\Framework\TestCase;

class CurrencyConverterTest extends TestCase
{

    private $encodedExchangeRates =
    '{
        "baseCurrency": "EUR",
        "exchangeRates" : {
            "EUR": 1,
            "USD": 5,
            "CHF": 0.97,
            "CNY": 2.3
        }
    }';


    /**
     * @test
     */
    public function testInputValue()
    {
        $converter = new CurrencyConverter($this->encodedExchangeRates);
        $output = $converter->convert(22.3);
        $currency = $converter->getConvertedCurrencyByType("USD");
        $this->assertEquals(111.2, $currency);
    }
}
