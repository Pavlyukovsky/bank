<?php

namespace app\services\interfaces;

use app\models\DepositAccount;

interface ChargeCommissionServiceInterface
{
    /**
     * Charge commission. Will return how much was charged.
     *
     * @param DepositAccount $depositAccount
     *
     * @throws \RuntimeException
     *
     * @return float
     */
    public function charge(DepositAccount $depositAccount): float;
}