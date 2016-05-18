<?php

use yii\db\Migration;

/**
 * Handles adding date_field to table `notification`.
 */
class m160518_163911_add_date_field_to_notification extends Migration
{
    const TABLE = '{{%notification}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->execute('ALTER TABLE ' . self::TABLE . ' ADD COLUMN [[createdAt]] DATETIME NOT NULL');
        $this->execute('ALTER TABLE ' . self::TABLE . ' ADD COLUMN [[updatedAt]] DATETIME');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn(self::TABLE, 'createdAt');
        $this->dropColumn(self::TABLE, 'updatedAt');
    }
}
