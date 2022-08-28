<?php

use App\CurrencyConverter;
use PHPUnit\Framework\TestCase;

class CurrencyConverterTest extends TestCase
{

    private $mockedEncodedExchangeRates =
    '{
        "baseCurrency": "EUR",
        "exchangeRates" : {
            "EUR": 1,
            "USD": 5,
            "CHF": 0.97,
            "CNY": 2.3
        }
    }';

    private $mockedEncodedFalseExchangeRates =
    '{
        "baseCurrency": "EUR",
        "exchangeRates" : {
            "EUR": 1,
            "USD": 5,
            "CHF": "test",
            "CNY": 2.3
        }
    }';


    private $mockedEncodedEmptyExchangeRates =
    '{
        "baseCurrency": "EUR",
        "exchangeRates" : {
        }
    }';


    public function testConvertedAmountIsCorrect()
    {
        $converter = new CurrencyConverter($this->mockedEncodedExchangeRates);
        $exchangeRates = $converter->getExchangeRates();
        $this->assertEquals(5, $exchangeRates["USD"]);
    }

    public function testCannotHandleEmptyExchangeRates()
    {
        $this->expectException(Exception::class);
        new CurrencyConverter($this->mockedEncodedEmptyExchangeRates);
    }

    public function testCannotHandleFalseExchangeRates()
    {
        $this->expectException(Exception::class);
        new CurrencyConverter($this->mockedEncodedFalseExchangeRates);
    }


    public function testCurrencyConverterOutputIsJSON()
    {
        $converter = new CurrencyConverter($this->mockedEncodedExchangeRates);
        $output = $converter->convert(1111);
        $this->assertEquals(true, is_array(json_decode($output, true)));
    }

    public function testBaseCurrencyIsSet()
    {
        $converter = new CurrencyConverter($this->mockedEncodedExchangeRates);
        $output = $converter->getBaseCurrency();
        $this->assertEquals("EUR",  $output);
    }
}
