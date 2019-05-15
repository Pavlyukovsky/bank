<?php

namespace app\models;

/**
 * This is the model class for table "deposit_account".
 *
 * @property int $id
 * @property int $user_id
 * @property string $balance
 * @property string $percent
 * @property string $open_date
 * @property string $next_payment_date
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 * @property TransactionHistory[] $transactionHistories
 */
class DepositAccount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deposit_account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'balance'], 'required'],
            [['user_id'], 'integer'],
            [['balance', 'percent'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'balance' => 'Balance',
            'percent' => 'Percent',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionHistories()
    {
        return $this->hasMany(TransactionHistory::class, ['deposit_account_id' => 'id']);
    }


    /**
     * Get all for charge percent.
     *
     * @param int $time
     * @return array|\yii\db\ActiveRecord[]|self[]
     */
    public static function getAllForCharge(int $time)
    {
        if ($time < 0) {
            throw new \RuntimeException('Time can\'t be less than 0');
        }

        $date = date("Y-m-d", $time);
        return self::find()->where(['<=', 'next_payment_date', $date])->all();
    }

    /**
     * Get all batch.
     *
     * @param int $batch Batch size.
     *
     * @return \yii\db\BatchQueryResult|\Iterator
     */
    public static function getAllBatch(int $batch = 100): \Iterator
    {
        return self::find()->batch($batch);
    }

//    /**
//     * Set next payment date.
//     *
//     * @param string $date
//     *
//     * @return string
//     */
//    public function getNextChangeDate(string $date): string
//    {
//        $date = getdate(strtotime($date));
//
//        $newDay = $date['mday'];
//        $newMonth = $date['mon'] + 1;
//        $newYear = $date['year'];
//        if ($newMonth > 12) {
//            $newYear++;
//            $newMonth = 1;
//        }
//
//        $newDate = sprintf('%s-%s-%s', $newYear, $newMonth, $newDay);
//
//        if (!checkdate($newMonth, $newDay, $newYear)) {
//            $newDate = date("Y-m-t", strtotime($newDate) - 1);
//        }
//        return $newDate;
//    }
}
