<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;

class SetupAdminForm extends Utilizador
{
    public $password;
    public $repeat_password;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
        [
            ['password', 'required', 'message' => 'Campo obrigatório'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength'], 'tooShort' => 'A palavra-passe deve conter pelo menos ' . Yii::$app->params['user.passwordMinLength'] . ' caracteres'],
            ['repeat_password', 'required', 'message' => 'Campo obrigatório'],
            ['repeat_password', 'string', 'min' => Yii::$app->params['user.passwordMinLength'], 'tooShort' => 'Deve conter pelo menos ' . Yii::$app->params['user.passwordMinLength'] . ' caracteres'],
            [['repeat_password'], 'compare', 'compareAttribute' => 'password', 'message' => 'A palavra-passe e a confirmação da nova palavra-passe devem ser iguais'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(),
        [
            'password' => 'Palavra-passe',
            'repeat_password' => 'Confirmar palavra-passe',
        ]);
    }


    /**
     * Regista o primeiro utilizador administrativo
     * @param bool $preAtivar NOT USED. Signature Only
     * @return bool whether the creating new account was successful
     */
    public function createUser(bool $preAtivar = false): bool
    {
        if (!$this->validate()) {
            return false;
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

}