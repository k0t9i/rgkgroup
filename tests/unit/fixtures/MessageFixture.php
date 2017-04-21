<?php

namespace app\tests\unit\fixtures;

use yii\test\ActiveFixture;

class MessageFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Message';
    public $depends = [
        'app\tests\unit\fixtures\UserFixture'
    ];
    public $dataFile = '@tests/unit/fixtures/data/messages.php';
}