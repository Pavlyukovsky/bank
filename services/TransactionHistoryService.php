<?php

namespace app\services;

use app\models\TransactionHistory;
use app\services\interfaces\TransactionHistoryServiceInterface;

class TransactionHistoryService implements TransactionHistoryServiceInterface
{
    /**
     * Log history.
     *
     * @param int $accountId
     * @param int $userId
     * @param int $type
     * @param float $amount
     *
     * @throws \RuntimeException
     *
     * @return void
     */
    public function logHistory(int $accountId, int $userId, int $type, float $amount): void
    {
        if (!$this->checkType($type)) {
            throw new \RuntimeException('Unknown type.');
        }

        $history = new TransactionHistory();
        $history->user_id = $userId;
        $history->deposit_account_id = $accountId;
        $history->amount = $amount;
        $history->type = $type;
        $history->save();
    }

    /**
     * Check type.
     *
     * @param int $type
     *
     * @return boolean
     */
    protected function checkType(int $type): bool
    {
        return isset(self::LIST_TYPES[$type]);
    }
}