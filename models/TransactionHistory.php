<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "transaction_history".
 *
 * @property int $id
 * @property int $user_id
 * @property int $deposit_account_id
 * @property int $type
 * @property string $amount
 * @property int $created_at
 * @property int $updated_at
 *
 * @property DepositAccount $depositAccount
 * @property User $user
 */
class TransactionHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'deposit_account_id', 'type'], 'required'],
            [['user_id', 'deposit_account_id', 'type'], 'integer'],
            [['amount'], 'number'],
            [['deposit_account_id'], 'exist', 'skipOnError' => true, 'targetClass' => DepositAccount::class, 'targetAttribute' => ['deposit_account_id' => 'id']],
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
            'deposit_account_id' => 'Deposit Account ID',
            'type' => 'Type',
            'amount' => 'Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepositAccount()
    {
        return $this->hasOne(DepositAccount::class, ['id' => 'deposit_account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
