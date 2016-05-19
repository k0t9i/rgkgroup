<?php

use yii\db\Migration;

/**
 * Handles adding name to table `notification`.
 */
class m160519_072731_add_name_to_notification extends Migration
{
    const TABLE = '{{%notification}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn(self::TABLE, 'name', \yii\db\Schema::TYPE_STRING . '(256) NOT NULL');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn(self::TABLE, 'name');
    }
}
