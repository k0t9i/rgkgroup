<?php

namespace app\tests\unit;

use app\models\Message;
use app\models\User;
use app\tests\unit\fixtures\MessageFixture;
use yii\db\ActiveQuery;

class MessageTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testGetUser()
    {
        $this->tester->haveFixtures([
            'messages' => MessageFixture::className()
        ]);
        $messageFixture = $this->tester->grabFixture('messages', 0);
        $message = Message::findOne($messageFixture['id']);
        $this->tester->assertInstanceOf(ActiveQuery::className(), $message->getUser());
        $this->tester->assertNotEmpty($message->user);
        $this->tester->assertInstanceOf(User::className(), $message->user);
        $this->tester->assertEquals($message->userId, $message->user->id);
    }

    public function testGetSender()
    {
        $this->tester->haveFixtures([
            'messages' => MessageFixture::className()
        ]);
        $messageFixture = $this->tester->grabFixture('messages', 0);
        $message = Message::findOne($messageFixture['id']);
        $this->tester->assertInstanceOf(ActiveQuery::className(), $message->getSender());
        $this->tester->assertNotEmpty($message->sender);
        $this->tester->assertInstanceOf(User::className(), $message->sender);
        $this->tester->assertEquals($message->senderId, $message->sender->id);
    }

    public function testGetUnreadCountForUser()
    {
        $this->tester->haveFixtures([
            'messages' => MessageFixture::className()
        ]);
        $this->tester->assertEquals(5, Message::getUnreadCountForUser(2));
        $this->tester->assertEquals(0, Message::getUnreadCountForUser(-1));
    }
}
