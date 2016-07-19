<?php

use yii\db\Migration;

class m160707_113027_nofications extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_notification}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
			'key' => $this->string()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_user_notification', '{{%user_notification}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%user_transport}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'transport_id' => $this->string()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_user_transport', '{{%user_transport}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%browsernotification}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
			'type' => $this->string()->notNull(),
			'key' => $this->string()->notNull(),
			'key_id' => $this->integer()->notNull(),
			'seen' => $this->boolean()->notNull(),
			'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_user_notify', '{{%browsernotification}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
	}

    public function down()
    {
		$this->dropTable('{{%user_notification}}');
		$this->dropTable('{{%user_transport}}');
		$this->dropTable('{{%browsernotification}}');

        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
