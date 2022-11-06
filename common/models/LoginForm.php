<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required', 'message' => 'Campo obrigatório'],
            // email tem de ser do tipo email
            ['email', 'email'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Palavra-Passe',
            'email' => 'E-Mail',
            'rememberMe' => "Lembrar-me"
        ];
    }

    /**
     * Realiza as devidas verificações e inicia a sessão do utilizador
     * @param array $allowedRoles Array de roles autorizadas a iniciar sessão
     * @see yii\rbac\Role
     * @return bool Se a sessão foi iniciada ou não
     */
    public function loginUser(array $allowedRoles): bool
    {
        if($this->validate())
        {
            $user = $this->getUser();
            if($user)
            {
                $auth = Yii::$app->authManager;

                $userRoles = $auth->getRolesByUser($user->id);

                $isLoginAllowed = false;
                foreach ($allowedRoles as $allowedRole) {
                    if(in_array($allowedRole, $userRoles))
                        $isLoginAllowed = true;
                }

                if($isLoginAllowed)
                {
                    if($user->validatePassword($this->password))
                    {
                        return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
                    }
                    else
                    {
                        $this->addError("password", "Credenciais incorretas");
                    }
                }
                else
                {
                    $this->addError("password", "Permissões insuficientes");
                }
            }
            else
            {
                $this->addError("password", "Credenciais incorretas");
            }
        }
        else
        {
            $this->addError("password", "Uhhh campos?");
        }
        return false;
    }

    /**
     * @deprecated Apenas está aqui para não rebentar com os testes. NÃO UTILIZAR
     * @return bool false
     */
    public function login()
    {
        return false;
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findOne(['email' => $this->email, 'status' => User::STATUS_ACTIVE]);
        }

        return $this->_user;
    }
}
