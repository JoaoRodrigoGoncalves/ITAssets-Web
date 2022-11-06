<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SetupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $role;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'O E-Mail indicado já está em utilização.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * Regista o primeiro utilizador administrativo
     * @return bool whether the creating new account was successful
     */
    public function setupFirstAdmin()
    {
        if (!$this->validate()) {
            return null; //TODO: Isto devia ser null ou false
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->status = User::STATUS_ACTIVE; //Pre ativar
        $user->setPassword($this->password);
        $user->generateAuthKey();

        if($user->save()){
            $auth = Yii::$app->authManager;
            $auth->assign($auth->getRole("administrador"), $user->id);
            return true;
        }
        return false;
    }

    public function createUser(bool $preAtivar = false)
    {
        if(!$this->validate())
        {
            return null; //TODO: Isto devia ser null ou false
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->status = $preAtivar ? User::STATUS_ACTIVE : User::STATUS_INACTIVE;
        $user->generateAuthKey();

        if($user->save())
        {
            $auth = Yii::$app->authManager;
            $auth->assign($auth->getRole($this->role), $user->id);
            return true;
        }
        return false;
    }
}
