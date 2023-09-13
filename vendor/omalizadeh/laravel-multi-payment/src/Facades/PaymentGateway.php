<?php

namespace Omalizadeh\MultiPayment\Facades;

use Closure;
use Illuminate\Support\Facades\Facade;
use Omalizadeh\MultiPayment\Gateway;
use Omalizadeh\MultiPayment\Invoice;
use Omalizadeh\MultiPayment\Receipt;
use Omalizadeh\MultiPayment\RedirectionForm;

/**
 * @method static RedirectionForm purchase(Invoice $invoice, ?Closure $closure = null)
 * @method static Receipt verify(Invoice $invoice)
 * @method static array refund(Invoice $invoice)
 * @method static array unverifiedPayments()
 * @method static Gateway setGateway(string $gateway)
 * @method static string getGatewayName()
 * @method static string getGatewayConfigKey()
 *
 * @see Gateway
 *
 */
class PaymentGateway extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Gateway::class;
    }
}
