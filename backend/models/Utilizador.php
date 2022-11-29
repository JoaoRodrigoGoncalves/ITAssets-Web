<?php

namespace backend\models;

use Exception;
use Yii;
use yii\base\Model;
use common\models\User;
use yii\web\NotFoundHttpException;

/**
 * Signup form
 */
class Utilizador extends Model
{
    public $username;
    public $email;
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
            ['email', 'email', 'message' => 'Não é um endereço de email válido'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'O E-Mail indicado já está em utilização.'],

            ['role', 'string'], // Isto ao ser mencionado obriga a que o campo seja carregado para o model ($this->load())
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Nome de utilizador',
            'email' => "E-Mail",
            'role' => 'Cargo',
        ];
    }

    public static function getRoleLabel($role): string
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

    public function createUser(bool $preAtivar = false): bool
    {
        if(!$this->validate())
        {
            Yii::$app->session->setFlash("error", "Validação falhou");
            return false;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;

        $user->status = $preAtivar ? User::STATUS_ACTIVE : User::STATUS_INACTIVE;
        $user->setPassword("password123");
        $user->generateAuthKey();

        if($user->save())
        {
            $auth = Yii::$app->authManager;
            $auth->assign($auth->getRole($this->role), $user->id);
            return true;
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function updateUser($id): bool
    {
        if(!$this->validate())
        {
            Yii::$app->session->setFlash("error", "Validação falhou");
            return false;
        }

        $user = User::findOne(['id' => $id]);
        $user->username = $this->username;
        $user->email = $this->email;

        if ($user->save())
        {
            $auth = Yii::$app->authManager;
            // Dar revoke aos roles atuais do utilizador para
            // depois atualizar com os novos
            $auth->revokeAll($id);
            $auth->assign(($auth->getRole($this->role)),$id);
            return true;
        }
        return false;
    }
}
