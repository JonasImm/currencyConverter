<?php

namespace App;

use Exception;

interface CurrencyConverterInterface
{
    public function convert(float $amount);
}

/**
 * Converts a currency based on a given float and a JSON exchange currency list
 * 
 * Expects a JSON (possibly XML) data source with BASECURRENCY and EXCHANGERATES on initiating
 * 
 */
class CurrencyConverter implements CurrencyConverterInterface
{

    private array $exchangeRates;
    private string $baseCurrency;

    /**
     * @param float $amount Amount to be converted
     */
    public function convert(float $amount): string
    {
        $convertedRates = [];

        foreach ($this->exchangeRates as $rateDesc => $rate) {
            $convertedRates[$rateDesc] = $rate && is_integer($rate) ? $rate * $amount : null;
        }
        return json_encode($convertedRates);
    }

    /**
     * @return array $exchangeRates
     */
    public function getExchangeRates(): array
    {
        return $this->exchangeRates;
    }

    /**
     * @return string $baseCurrency
     */
    public function getBaseCurrency(): string
    {
        return $this->baseCurrency;
    }

    /**
     * @return string Error Message
     */
    private function displayError(string $errorMessage): string
    {
        return "ERROR: " . $errorMessage;
    }

    /**
     * Notice: If format will change, one can append below and commented line of code
     * @param string $exchangeRates_encoded
     * @throws Exception If wrong format or incorret type submitted
     */
    private function setExchangeRates(string $exchangeRates_encoded)
    {
        // $exchangeRates_decoded = simplexml_load_string($exchangeRates_encoded);
        // if ($exchangeRates_decoded === FALSE) {
        //     throw new Exception("Wrong format submitted. Input expected to be XML");
        // } else {
        //     // $exchangeRates_encoded = json_decode($exchangeRates_encoded)
        // }
        $exchangeRates_decoded = json_decode($exchangeRates_encoded, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($exchangeRates_decoded)) {

            if (array_key_exists("exchangeRates", $exchangeRates_decoded) && array_key_exists("baseCurrency", $exchangeRates_decoded)) {
                $this->exchangeRates = $exchangeRates_decoded["exchangeRates"];
                $this->baseCurrency = $exchangeRates_decoded["baseCurrency"];
            } else {
                throw new Exception("Submitted JSON is incomplete. Please provide the baseCurrency and corresponding exhange rates");
            }
        } else {
            throw new Exception("Wrong format submitted. Input expected to be JSON");
        }
    }

    function __construct(string $exchangeRates_encoded)
    {
        $this->setExchangeRates($exchangeRates_encoded);
    }
}


// $json = '{
//     "baseCurrency": "EUR",
//     "exchangeRates" : {
//     "EUR": 1,
//     "USD": 5,
//     "CHF": 0.97,
//     "CNY": 2.3
//     }
//     }';

// $currencyConverter = new CurrencyConverter($json);

// $string = $currencyConverter->convert(22.3);

// echo '<pre>';
// print_r($string);
// echo '</pre>';
