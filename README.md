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

## Understanding/Interpretation:

In your task you described the converting as expacting one input but displayed an interface with two params. I rewrote this to expect only one param.
I made the converter to convert a given amount based on the data input on initialzing the class and hope that was correctly assumed.

## Approach:

As unit testing is a new one for me, I watched various videos and documentation. I found [Gary Clarke](https://www.youtube.com/watch?v=kkU43JdJQBE) to be very helpful. For timing reasons I implemented 5 tests.

As for the **converter**, I already mentioned my thoughts on how I thought the converter will handle a input.

## Struggels:

I struggeled with installing PHP and PHPUnit as we usually working only on the server side and it took me longer than I'd hope it would. But I managed to setup everything accordingly.

As mentioned before, we never worked with UNIT Testing but I found this to be quite interessting and challenging.
