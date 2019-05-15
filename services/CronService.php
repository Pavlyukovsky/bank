<?php

namespace app\services;


use app\models\DepositAccount;
use app\services\interfaces\ChargeCommissionServiceInterface;
use app\services\interfaces\ChargePercentServiceInterface;
use app\services\interfaces\TransactionHistoryServiceInterface;
use yii\di\Instance;

class CronService
{
    /**
     * Cron run every day.
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function process(): void
    {
        $this->processPercent();
        if ((int)date('d') === 1) {
            $this->processCommission();
        }
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    protected function processPercent(): string
    {
        $depositAccounts = DepositAccount::getAllForCharge(time());

        if (empty($depositAccounts)) {
            return 'OK';
        }

        /** @var ChargePercentServiceInterface $chargePercentService */
        $chargePercentService = Instance::ensure(ChargePercentServiceInterface::class);

        /** @var TransactionHistoryServiceInterface $transactionHistory */
        $transactionHistory = Instance::ensure(TransactionHistoryServiceInterface::class);

        foreach ($depositAccounts as $depositAccount) {
            $amount = $chargePercentService->chargePercent($depositAccount);
            $depositAccount->save();

            $transactionHistory->logHistory($depositAccount->id, $depositAccount->user_id, $transactionHistory::TYPE_CHARGE_PERCENT, $amount);
        }
        return 'OK';
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    protected function processCommission(): void
    {
        /** @var ChargeCommissionServiceInterface $chargeCommissionService */
        $chargeCommissionService = Instance::ensure(ChargeCommissionServiceInterface::class);

        /** @var TransactionHistoryServiceInterface $transactionHistory */
        $transactionHistory = Instance::ensure(TransactionHistoryServiceInterface::class);

        foreach (DepositAccount::getAllBatch() as $depositAccounts) {
            foreach ($depositAccounts as $depositAccount) {
                /** @var $depositAccount DepositAccount */
                $amount = $chargeCommissionService->charge($depositAccount);
                $depositAccount->save(false); // Without validation.

                $transactionHistory->logHistory($depositAccount->id, $depositAccount->user_id, $transactionHistory::TYPE_CHARGE_COMMISSION, $amount);
            }
        }
    }
}