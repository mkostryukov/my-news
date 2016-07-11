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

        $this->createTable('{{%notify_user}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
			'key' => $this->string()->notNull()->defaultValue('info'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addForeignKey('fk_notify_user', '{{%notify_user}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%notify_transport}}', [
            'id' => $this->primaryKey(),
            'notify_user_id' => $this->integer()->notNull(),
            'transport_id' => $this->string()->notNull()->defaultValue('info'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addForeignKey('fk_notify_transport', '{{%notify_transport}}', 'notify_user_id', '{{%notify_user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%notify_user}}');
        $this->dropTable('{{%notify_transport}}');

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
