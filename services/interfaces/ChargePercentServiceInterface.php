<?php

namespace app\services\interfaces;

use app\models\DepositAccount;

interface ChargePercentServiceInterface
{
    /**
     * Charge Percent. Will return how much was charged.
     *
     * @param DepositAccount $depositAccount
     *
     * @return float
     */
    public function chargePercent(DepositAccount $depositAccount): float;

    /**
     * Set next payment date.
     *
     * @param string $date
     *
     * @return string
     */
    public function getNextChangeDate(string $date): string;
}