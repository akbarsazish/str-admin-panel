<?php

namespace Omalizadeh\MultiPayment\Drivers\Contracts;

interface UnverifiedPaymentsInterface
{
    public function latestUnverifiedPayments(): array;
}
