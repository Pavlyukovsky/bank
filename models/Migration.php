<?php

namespace app\models;

/**
 * Migration
 *
 * @var $tableOptions string
 * @var $dbType string
 * @var $restrict string
 * @var $cascade string
 */
class Migration extends \yii\db\Migration
{
    /**
     * @var string
     */
    protected $tableOptions;

    /**
     * @var string
     */
    protected $restrict = 'RESTRICT';

    /**
     * @var string
     */
    protected $cascade = 'CASCADE';

    /**
     * @var string
     */
    protected $dbType;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        switch ($this->db->driverName) {
            case 'mysql':
                $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                $this->dbType = 'mysql';
                break;
            case 'pgsql':
                $this->tableOptions = null;
                $this->dbType = 'pgsql';
                break;
            case 'dblib':
            case 'mssql':
            case 'sqlsrv':
                $this->restrict = 'NO ACTION';
                $this->tableOptions = null;
                $this->dbType = 'sqlsrv';
                break;
            default:
                throw new \RuntimeException('Your database is not supported!');
        }
    }

    /*
     * Examples
     *
     $this->createTable('{{%user}}', [
            'id'                   => $this->primaryKey(),
            'username'             => $this->string(25)->notNull(),
            'email'                => $this->string(255)->notNull(),
            'password_hash'        => $this->string(60)->notNull(),
            'auth_key'             => $this->string(32)->notNull(),
            'confirmation_token'   => $this->string(32)->null(),
            'confirmation_sent_at' => $this->integer()->null(),
            'confirmed_at'         => $this->integer()->null(),
            'unconfirmed_email'    => $this->string(255)->null(),
            'recovery_token'       => $this->string(32)->null(),
            'recovery_sent_at'     => $this->integer()->null(),
            'blocked_at'           => $this->integer()->null(),
            'registered_from'      => $this->integer()->null(),
            'logged_in_from'       => $this->integer()->null(),
            'logged_in_at'         => $this->integer()->null(),
            'created_at'           => $this->integer()->notNull(),
            'updated_at'           => $this->integer()->notNull(),
        ], $this->tableOptions);
        $this->createIndex('{{%user_unique_username}}', '{{%user}}', 'username', true);
        $this->createIndex('{{%user_unique_email}}', '{{%user}}', 'email', true);
        $this->createIndex('{{%user_confirmation}}', '{{%user}}', 'id, confirmation_token', true);
        $this->createIndex('{{%user_recovery}}', '{{%user}}', 'id, recovery_token', true);
        $this->createTable('{{%profile}}', [
            'user_id'        => $this->integer()->notNull()->append('PRIMARY KEY'),
            'name'           => $this->string(255)->null(),
            'public_email'   => $this->string(255)->null(),
            'gravatar_email' => $this->string(255)->null(),
            'gravatar_id'    => $this->string(32)->null(),
            'location'       => $this->string(255)->null(),
            'website'        => $this->string(255)->null(),
            'bio'            => $this->text()->null(),
        ], $this->tableOptions);
        $this->addForeignKey('{{%fk_user_profile}}', '{{%profile}}', 'user_id', '{{%user}}', 'id', $this->cascade, $this->restrict);
     */
}

