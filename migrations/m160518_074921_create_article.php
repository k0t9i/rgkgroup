<?php

use yii\db\Migration;

/**
 * Handles the creation for table `article`.
 */
class m160518_074921_create_article extends Migration
{
    const TABLE = '{{%article}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'title' => $this->string(512)->notNull(),
            'body' => $this->text(),
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
