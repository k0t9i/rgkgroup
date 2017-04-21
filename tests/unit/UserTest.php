<?php

namespace app\tests;

use app\models\User;
use app\tests\fixtures\UserFixtures;
use Codeception\Util\Stub;
use yii\base\Security;

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
        $userFixture = $this->tester->grabFixture('users', 0);

        $this->tester->assertNotEmpty($user = User::findIdentity($userFixture['id']));
        $this->tester->assertEquals($userFixture['username'], $user->username);

        $this->tester->assertEmpty(User::findIdentity(-1));
    }

    public function testValidatePassword()
    {
        $expectedPassword = 'password123';
        $expectedHash = '$2y$13$.sPeWv2B/aTqg.yp9pim/Oqmdq0hI.acALy1FLFilut2XGHFtfFF.';

        /** @var Security $security */
        $security = Stub::makeEmpty('yii\base\Security', [
            'validatePassword' => function ($password, $hash) use ($expectedPassword, $expectedHash) {
                return $password == $expectedPassword &&
                    $hash == $expectedHash;
            }
        ]);
        $user = new User([
            'passwordHash' => $expectedHash // password123
        ]);
        $this->tester->assertTrue($user->validatePassword($expectedPassword, $security));
        $this->tester->assertFalse($user->validatePassword($expectedPassword . 'invalid', $security));
    }

    public function testFindIdentityByAccessToken()
    {
        $this->expectException('yii\base\NotSupportedException');
        User::findIdentityByAccessToken('123');
    }

    public function testGetAuthKey()
    {
        $this->expectException('yii\base\NotSupportedException');
        (new User())->getAuthKey();
    }

    public function testValidateAuthKey()
    {
        $this->expectException('yii\base\NotSupportedException');
        (new User())->validateAuthKey('123');
    }

    public function testGetId()
    {
        $user = new User([
            'id' => 2811
        ]);
        $this->tester->assertTrue($user->id == $user->getId());
        $this->tester->assertFalse(-1 == $user->getId());
    }
}