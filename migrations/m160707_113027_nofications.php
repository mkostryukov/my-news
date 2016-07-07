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

        $this->createTable('{{%notification}}', [
            'id' => $this->primaryKey(),
			'type' => $this->string()->notNull()->defaultValue('info'),
            'title' => $this->string()->notNull(),
			'message' => $this->text(),
			'location' => $this->string()->notNull(),
            'recipient' => $this->integer()->notNull()->defaultValue(0),
            'author' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ], $tableOptions);

         $this->addForeignKey('fk_notification_author', '{{%notification}}', 'author', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
         $this->addForeignKey('fk_notification_recipient', '{{%notification}}', 'recipient', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable('{{%notification}}');

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
