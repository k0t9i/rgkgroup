<?php

namespace app\tests;

use app\models\User;
use app\tests\fixtures\UserFixtures;

class UserTest extends \Codeception\Test\Unit
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

    public function testFindByIdentity()
    {
        $this->tester->haveFixtures(['users' => UserFixtures::className()]);

        $this->tester->assertNotEmpty($user = User::findIdentity(1234));
        $this->tester->assertEquals('test', $user->username);

        $this->tester->assertEmpty(User::findIdentity(9999));
    }

    public function testValidatePassword()
    {
        $user = new User([
            'passwordHash' => '$2y$13$.sPeWv2B/aTqg.yp9pim/Oqmdq0hI.acALy1FLFilut2XGHFtfFF.' // password123
        ]);
        $this->tester->assertTrue($user->validatePassword('password123'));

        $user = new User([
            'passwordHash' => '$2y$13$.sPeWv2B/aTqg.yp9pim/Oqmdq0hI.acALy1FLFilut2XGHFtfFF.' // password123
        ]);
        $this->tester->assertFalse($user->validatePassword('password123invalid'));
    }
}