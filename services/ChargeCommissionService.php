<?php

namespace app\services;

use app\models\DepositAccount;
use app\services\interfaces\ChargeCommissionServiceInterface;

class ChargeCommissionService implements ChargeCommissionServiceInterface
{
    protected const MIN_PERCENT = 5;
    protected const MIDDLE_PERCENT = 6;
    protected const MAX_PERCENT = 7;

    protected const MIN_VALUE = 50;
    protected const MAX_VALUE = 5000;

    /**
     * Charge commission. Will return how much was charged.
     *
     * @param DepositAccount $depositAccount
     *
     * @throws \RuntimeException
     * @throws \Exception
     *
     * @return float
     */
    public function charge(DepositAccount $depositAccount): float
    {
        $balance = $depositAccount->balance;

        if ((int)$balance >= 0 && (int)$balance < 1000) {
            $commission = $this->getCommission($balance, self::MIN_PERCENT);
            if ($commission < self::MIN_VALUE) {
                $commission = self::MIN_VALUE;
            }

            $commission = $this->getCommissionByDate($commission, $depositAccount->open_date);

            $depositAccount->balance -= $commission; //Balance may be less than 0.
            return $commission;
        }

        if ((int)$balance >= 1000 && (int)$balance < 10000) {
            $commission = $this->getCommission($balance, self::MIDDLE_PERCENT);
            $commission = $this->getCommissionByDate($commission, $depositAccount->open_date);

            $depositAccount->balance -= $commission;
            return $commission;
        }

        if ((int)$balance >= 10000) {
            $commission = $this->getCommission($balance, self::MAX_PERCENT);
            if ($commission > self::MAX_VALUE) {
                $commission = self::MAX_VALUE;
            }
            $commission = $this->getCommissionByDate($commission, $depositAccount->open_date);

            $depositAccount->balance -= $commission;
            return $commission;
        }

        throw new \RuntimeException('Balance wrong.');
    }

    /**
     * Get commission.
     *
     * @param float $amount
     * @param int $percent
     *
     * @return float
     */
    protected function getCommission(float $amount, int $percent): float
    {
        return (float)($amount * $percent / 100);
    }

    /**
     * Get commission if open date less than month.
     *
     * @param float $commission
     * @param string $openDate
     *
     * @return float
     * @throws \Exception
     */
    protected function getCommissionByDate(float $commission, string $openDate): float
    {
        $diff = (new \DateTime())->diff(new \DateTime($openDate));

        if ($diff->m > 0) {
            return $commission;
        }

        return $commission * ($diff->d / date('t', '-1month'));
    }
}