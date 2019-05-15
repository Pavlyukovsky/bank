<?php

namespace app\models;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $inn
 * @property string $name
 * @property string $surname
 * @property int $gender
 * @property int $birthday_date
 * @property int $created_at
 * @property int $updated_at
 *
 * @property DepositAccount[] $depositAccounts
 * @property TransactionHistory[] $transactionHistories
 */
class User extends \yii\db\ActiveRecord
{
    public const GENDER_MALE = 0;
    public const GENDER_WOMEN = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inn', 'gender', 'birthday_date'], 'required'],
            [['gender', 'birthday_date'], 'integer'],
            [['inn', 'name', 'surname'], 'string', 'max' => 255],
            [['inn'], 'unique'],
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
            'inn' => 'Inn',
            'name' => 'Name',
            'surname' => 'Surname',
            'gender' => 'Gender',
            'birthday_date' => 'Birthday Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepositAccounts()
    {
        return $this->hasMany(DepositAccount::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionHistories()
    {
        return $this->hasMany(TransactionHistory::class, ['user_id' => 'id']);
    }
}
