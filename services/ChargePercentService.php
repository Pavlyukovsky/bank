<?php

namespace app\services;


use app\models\DepositAccount;
use app\services\interfaces\ChargePercentServiceInterface;

class ChargePercentService implements ChargePercentServiceInterface
{
    /**
     * Charge Percent. Will return how much was charged.
     *
     * @param DepositAccount $depositAccount
     *
     * @return float
     */
    public function chargePercent(DepositAccount $depositAccount): float
    {
        $amount = $depositAccount->balance * $depositAccount->percent / 100;
        $depositAccount->balance += $amount;
        $depositAccount->next_payment_date = $this->getNextChangeDate($depositAccount->next_payment_date);

        return (float)$amount;
    }

    /**
     * Set next payment date.
     *
     * @param string $date
     *
     * @return string
     */
    public function getNextChangeDate(string $date): string
    {
        $date = getdate(strtotime($date));

        $newDay = $date['mday'];
        $newMonth = $date['mon'] + 1;
        $newYear = $date['year'];
        if ($newMonth > 12) {
            $newYear++;
            $newMonth = 1;
        }

        $newDate = sprintf('%s-%s-%s', $newYear, $newMonth, $newDay);

        if (!checkdate($newMonth, $newDay, $newYear)) {
            $newDate = date("Y-m-t", strtotime($newDate) - 1);
        }
        return $newDate;
    }
}