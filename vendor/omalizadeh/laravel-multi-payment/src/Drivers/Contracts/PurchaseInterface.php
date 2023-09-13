<?php

namespace Omalizadeh\MultiPayment\Drivers\Contracts;

use Omalizadeh\MultiPayment\Invoice;
use Omalizadeh\MultiPayment\Receipt;
use Omalizadeh\MultiPayment\RedirectionForm;

interface PurchaseInterface
{
    public function purchase(): string;

    public function pay(): RedirectionForm;

    public function verify(): Receipt;

    public function setInvoice(Invoice $invoice): PurchaseInterface;
}
