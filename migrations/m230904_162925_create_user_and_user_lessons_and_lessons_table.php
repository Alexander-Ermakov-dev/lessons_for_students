<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_lessons}}`.
 */
class m230904_162925_create_user_and_user_lessons_and_lessons_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'verification_token' => $this->string()->defaultValue(null),
        ], $tableOptions);

        $this->createTable('{{%lessons}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'video_url' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%user_lessons}}', [
            'user_id' => $this->integer()->notNull(),
            'lesson_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'fk-user_lessons-user_id',
            '{{%user_lessons}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-user_lessons-lesson_id',
            '{{%user_lessons}}',
            'lesson_id',
            '{{%lessons}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-user_lessons-user_id-lesson_id',
            '{{%user_lessons}}',
            ['user_id', 'lesson_id'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_lessons}}');
        $this->dropTable('{{%lessons}}');
        $this->dropTable('{{%user}}');
    }
}
