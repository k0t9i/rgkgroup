<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\base\Security;
use yii\web\User  as WebUser;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 * @package app\models
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    private $user_ = false;
    private $webUser_;
    private $security_;

    /**
     * LoginForm constructor.
     *
     * @param Security $security
     * @param WebUser $user
     * @param array $config
     */
    public function __construct(Security $security, WebUser $user, array $config = [])
    {
        parent::__construct($config);
        $this->webUser_ = $user;
        $this->security_ = $security;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password, $this->security_)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return $this->webUser_->login($this->getUser());
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->user_ === false) {
            $this->user_ = User::findOne(['username' => $this->username]);
        }
        return $this->user_;
    }
}
