<?php

namespace App;

use Exception;

use function PHPUnit\Framework\throwException;

interface CurrencyConverterInterface
{
    public function convert(float $amount);
    public function getExchangeRates(): array;
    public function setExchangeRate(string $rateDesc, float $newRate): bool;
    public function getBaseCurrency(): string;
    public function getConvertedCurrencyByType(string $rateDesc): string;
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
    private array $convertedCurrency;
    private string $baseCurrency;
    private float $amount;

    /**
     * @param float $amount Amount to be converted
     */
    public function convert(float $amount): string
    {
        $convertedRates = [];
        $this->amount = $amount;
        foreach ($this->exchangeRates as $rateDesc => $rate) {

            if ($rate) {
                $convertedCurrencyRate =  $rate * $amount;
            } else {
                $convertedCurrencyRate =  null;
            }

            $convertedRates[$rateDesc] = $convertedCurrencyRate;
            $this->convertedCurrency[$rateDesc] = $convertedCurrencyRate;
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
     * @param string $rateDesc
     * @param float $newRate
     * @return bool TRUE on success, FALSE on error
     */
    public function setExchangeRate(string $rateDesc, float $newRate): bool
    {
        if (array_key_exists($rateDesc, $this->convertedCurrency)) {
            $this->exchangeRates[$rateDesc] = $newRate;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string String indicating the converted value regarding the submitted rate
     */
    public function getConvertedCurrencyByType(string $rateDesc): string
    {
        return array_key_exists($rateDesc, $this->convertedCurrency) ? $this->amount . " " . $this->baseCurrency . " eqauls " . $this->convertedCurrency[$rateDesc] . " " . $rateDesc : "Submitted rate (" . $rateDesc . ") is not available to convert.";
    }

    /**
     * @return string $baseCurrency
     */
    public function getBaseCurrency(): string
    {
        return $this->baseCurrency;
    }

    /**
     * @throws Exception If wrong format or incorret exchange rate
     */
    private function validateExchangeRates(array $exchangeRates): bool
    {
        if (count($exchangeRates) == 0) {
            throw new Exception("Please provide at least 1 exchange rate.");
        } else {

            foreach ($exchangeRates as $rateDesc => $rate) {
                if ($rateDesc && (is_integer($rate) || is_float($rate))) {
                    continue;
                } else {
                    throw new Exception("Submitted exchange rate (" . $rateDesc . "->" . $rate . ") is wrongfully formatted.");
                }
            }
            return true;
        }
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
                $this->exchangeRates = $this->validateExchangeRates($exchangeRates_decoded["exchangeRates"]) ? $exchangeRates_decoded["exchangeRates"] : [];
                $this->baseCurrency = $exchangeRates_decoded["baseCurrency"];
            } else {
                throw new Exception("Submitted JSON is incomplete. Please provide the baseCurrency and corresponding exchange rates");
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
