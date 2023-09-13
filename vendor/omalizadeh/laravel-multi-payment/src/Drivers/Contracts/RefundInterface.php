<?php

namespace Omalizadeh\MultiPayment\Drivers\Contracts;

interface RefundInterface
{
    public function refund(): array;
}
