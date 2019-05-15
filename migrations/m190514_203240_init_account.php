<?php

use app\models\Migration;

/**
 * Class m190514_203240_init
 */
class m190514_203240_init_account extends Migration
{
    protected const TABLE_NAME_USER = '{{%user}}';

    public function up()
    {
        $this->createTable(
            self::TABLE_NAME_USER, [
            'id' => $this->primaryKey(),
            'inn' => $this->string()->notNull()->unique(),
            'name' => $this->string(),
            'surname' => $this->string(),
            'gender' => $this->boolean()->notNull(),
            'birthday_date' => $this->date(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ],
            $this->tableOptions
        );
    }

    public function down()
    {
        $this->dropTable(self::TABLE_NAME_USER);
    }
}
