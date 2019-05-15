<?php

use app\models\Migration;

/**
 * Class m190514_211325_init_transaction_history
 */
class m190514_211325_init_transaction_history extends Migration
{
    protected const TABLE_NAME_USER = '{{%user}}';
    protected const TABLE_NAME_DEPOSIT_ACCOUNT = '{{%deposit_account}}';
    protected const TABLE_NAME_TRANSACTION_HISTORY = '{{%transaction_history}}';

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable(
            self::TABLE_NAME_TRANSACTION_HISTORY,
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer()->notNull(),
                'deposit_account_id' => $this->integer()->notNull(),
                'type' => $this->integer()->unsigned()->notNull(),
                'amount' => $this->decimal(10, 2)->unsigned(),
                'created_at' => $this->integer()->unsigned()->notNull(),
                'updated_at' => $this->integer()->unsigned()->notNull(),
            ],
            $this->tableOptions
        );

        $this->addForeignKey(
            '{{%fk_user_transaction_history}}',
            self::TABLE_NAME_TRANSACTION_HISTORY,
            'user_id',
            self::TABLE_NAME_USER,
            'id'
        );
        $this->addForeignKey(
            '{{%fk_deposit_account_transaction_history}}',
            self::TABLE_NAME_TRANSACTION_HISTORY,
            'deposit_account_id',
            self::TABLE_NAME_DEPOSIT_ACCOUNT,
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey('{{%fk_deposit_account_transaction_history}}', self::TABLE_NAME_TRANSACTION_HISTORY);
        $this->dropForeignKey('{{%fk_user_transaction_history}}', self::TABLE_NAME_TRANSACTION_HISTORY);

        $this->dropTable(self::TABLE_NAME_TRANSACTION_HISTORY);
    }
}
