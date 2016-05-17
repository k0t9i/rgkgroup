<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m160517_185653_create_user extends Migration
{
    const TABLE = '{{%user}}';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'username' => $this->string(256)->notNull()->unique(),
            'passwordHash' => $this->string(64)->notNull(),
            'lastname' => $this->string(512)->notNull(),
            'firstname' => $this->string(512)->notNull(),
            'email' => $this->string(256)->notNull()->unique(),
            'createdAt' => $this->dateTime()->notNull(),
            'updatedAt' => $this->dateTime()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(self::TABLE);
    }
}
