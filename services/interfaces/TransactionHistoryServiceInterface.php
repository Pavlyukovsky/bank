<?php

namespace app\services\interfaces;

interface TransactionHistoryServiceInterface
{
    public const TYPE_CHARGE_COMMISSION = 0;
    public const TYPE_CHARGE_PERCENT = 1;

    public const LIST_TYPES = [
        self::TYPE_CHARGE_COMMISSION => self::TYPE_CHARGE_COMMISSION,
        self::TYPE_CHARGE_PERCENT => self::TYPE_CHARGE_PERCENT,
    ];

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
    public function logHistory(int $accountId, int $userId, int $type, float $amount): void;
}