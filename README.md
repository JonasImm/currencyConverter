# currencyConverter

## Task:

You need to design a simple converter which accepts a monetary value in a certain currency as an
argument and outputs list of results converted to various world currencies (requested currencies and
exchange rates will come from a data source).
Data source for currencies and exchange rates (for now data is in JSON, but you've already heard
that soon you'll need to switch to CSV or XML so make the switch as easy as possible):

```JSON
{
    "baseCurrency": "EUR",
    "exchangeRates" : {
        "EUR": 1,
        "USD": 5,
        "CHF": 0.97,
        "CNY": 2.3
    }
}
```

The output (list of results) should be in JSON or CVS format (might change in the future).
Possible interface for the converter, it’s just an example, feel free to improve, modify it or define
your own:

```php
interface CurrencyConverterInterface
{
    public function convert(float $amount, Currency $currency): string;
}
```
