<?php
namespace App\Helper;

use AmrShawky\LaravelCurrency\Facade\Currency;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Models\Money;

class CurrencyExchange
{

    public static function changeCurrency($fromCurrency, $toCurrency, $amount = 1)
    {
        $conversion = self::getExchangeAmount($fromCurrency, $toCurrency, $amount);
        $exchnageRate = self::getExchangeRate($fromCurrency, $toCurrency);
        
        $response = [];
        $response['conversion_rate'] = $exchnageRate;
        $response['converted_amount'] = $conversion;
        $response['converted_to_currency'] = $toCurrency;
        $response['converted_from_currency'] = $fromCurrency;

        return $response;
    }

    public static function getExchangeRate($fromCurrency, $toCurrency)
    {
        $exchnageRate = Currency::rates()->latest()
            ->symbols([$toCurrency])
            ->base($fromCurrency)
            ->get();
      
        if (! isset($exchnageRate[$toCurrency])) {
            throw new BadRequestHttpException("Something went wrong. Please try again!");
        }

        return $exchnageRate[$toCurrency];
    }

    public static function getExchangeAmount($fromCurrency, $toCurrency, $amount)
    {
        $conversionAmount = Currency::convert()->from($fromCurrency)
            ->to($toCurrency)
            ->amount($amount)
            ->round(2)
            ->get();
            
        if (! isset($conversionAmount)) {
            throw new BadRequestHttpException("Something went wrong. Please try again!");
        }

        return $conversionAmount;
    }

    public static function getExchangedMoney(Money $money, $toCurrency)
    {
        $money->value = CurrencyExchange::getExchangeAmount($money->currency, $toCurrency, $money->value);
        $money->currency = $toCurrency;
        $money->save();

        return $money;
    }
}

