<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class Utilizador extends Model
{
    public $username;
    public $email;
    public $password;
    public $repeat_password;
    public $role;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'message' => 'Campo obrigatório'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'Campo obrigatório'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'O E-Mail indicado já está em utilização.'],

            ['password', 'required', 'message' => 'Campo obrigatório'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength'], 'tooShort' => 'A palavra-passe deve conter pelo menos ' . Yii::$app->params['user.passwordMinLength'] . ' caracteres'],

            ['repeat_password', 'required', 'message' => 'Campo obrigatório'],
            ['repeat_password', 'string', 'min' => Yii::$app->params['user.passwordMinLength'], 'tooShort' => 'Deve conter pelo menos ' . Yii::$app->params['user.passwordMinLength'] . ' caracteres'],
            [['repeat_password'], 'compare', 'compareAttribute' => 'password', 'message' => 'A palavra-passe e a confirmação da nova palavra-passe devem ser iguais'],

            ['role', 'string'], // Isto ao ser mencionado obriga a que o campo seja carregado para o model ($this->load())
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Nome de utilizador',
            'email' => "E-Mail",
            'password' => 'Palavra-passe',
            'repeat_password' => 'Confirmar palavra-passe',
            'role' => 'Cargo',
        ];
    }

    public static function getRoleLabel($role)
    {
        switch($role)
        {
            case "administrador":
                return "Administrador";

            case "operadorLogistica":
                return "Operador Logistica";

            case "funcionario":
                return "Funcionário";

            default:
                return $role;
        }
    }

    /**
     * Regista o primeiro utilizador administrativo
     * @return bool whether the creating new account was successful
     */
    public function setupFirstAdmin()
    {
        if (!$this->validate()) {
            return null;
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
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;

        $user->status = $preAtivar ? User::STATUS_ACTIVE : User::STATUS_INACTIVE;
        $user->setPassword($this->password);
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
