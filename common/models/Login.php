<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class Login extends Model
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
            $this->addError("password", "Validação falhou");
        }
        return false;
    }

    /**
     * Realiza as devidas verificações e devolve o token de autenticação
     * do utilizador quando as credenciais corretas são indicadas.
     * @return false|string false se existir algum erro, string com o token caso contrário
     */
    public function APILogin()
    {
        if($this->validate())
        {
            $user = $this->getUser();
            if($user)
            {
                if($user->validatePassword($this->password))
                {
                    if(!$user->auth_key)
                    {
                        $user->generateAuthKey();
                        $user->save();
                    }
                    return $user->auth_key;
                }
            }
            // Tanto a falha na validação de email como a de password passam aqui.
            // Para não indicar explicitamente se a autenticação falhou por a conta
            // não existir ou pela palavra-passe estar errada, aplicamos o erro só no atributo password
            $this->addError("password", "Credenciais incorretas");
        }
        // Quando a validação falha, erros já são adicionados pela validação
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
