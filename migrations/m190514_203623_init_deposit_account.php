<?php

/**
 * Class m190514_203623_init_deposit_account
 */
class m190514_203623_init_deposit_account extends \app\models\Migration
{
    protected const TABLE_NAME_USER = '{{%user}}';
    protected const TABLE_NAME_DEPOSIT_ACCOUNT = '{{%deposit_account}}';

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable(
            self::TABLE_NAME_DEPOSIT_ACCOUNT,
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer()->notNull(),
                'balance' => $this->decimal(10, 2)->notNull(),
                'percent' => $this->decimal(5, 2)->unsigned()->notNull(),
                'open_date' => $this->date()->notNull(),
                'next_payment_date' => $this->date()->notNull(),
                'created_at' => $this->integer()->unsigned()->notNull(),
                'updated_at' => $this->integer()->unsigned()->notNull(),
            ],
            $this->tableOptions
        );

        $this->addForeignKey(
            '{{%fk_user_deposit_account}}',
            self::TABLE_NAME_DEPOSIT_ACCOUNT,
            'user_id',
            self::TABLE_NAME_USER,
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey('{{%fk_user_deposit_account}}', self::TABLE_NAME_DEPOSIT_ACCOUNT);

        $this->dropTable(self::TABLE_NAME_DEPOSIT_ACCOUNT);
    }
}
