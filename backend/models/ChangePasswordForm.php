<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{

    public $old_password;
    public $new_password;
    public $repeat_password;

    public function rules()
    {
        return [
            ['old_password', 'required', 'message' => 'Campo obrigatório'],

            ['new_password', 'required', 'message' => 'Campo obrigatório'],
            ['new_password', 'string', 'min' => Yii::$app->params['user.passwordMinLength'], 'tooShort' => 'Deve conter pelo menos ' . Yii::$app->params['user.passwordMinLength'] . ' caracteres'],

            ['repeat_password', 'required', 'message' => 'Campo obrigatório'],
            ['repeat_password', 'string', 'min' => Yii::$app->params['user.passwordMinLength'], 'tooShort' => 'Deve conter pelo menos ' . Yii::$app->params['user.passwordMinLength'] . ' caracteres'],
            [['repeat_password'], 'compare', 'compareAttribute' => 'new_password', 'message' => 'A nova palavra-passe e a confirmação da nova palavra-passe devem ser iguais'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'old_password' => 'Palavra-passe atual',
            'new_password' => 'Nova palavra-passe',
            'repeat_password' => "Confirmar palavra-passe"
        ];
    }

    public function updatePassword()
    {
        if(!$this->validate())
        {
            return null;
        }

        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->validatePassword($this->old_password))
        {
            $user->setPassword($this->new_password);
            $user->save();
            Yii::$app->session->setFlash('success', 'Palavra-passe alterada com sucesso');
            return true;
        }
        else
        {
            // Feito com sessão aqui ao invés de seterror por causa da forma de
            // como o flow do pedido está formado. Isto é convertido mais tarde em
            // erro de atributo
            Yii::$app->session->setFlash('error_old_password', 'Palavra-passe antiga incorreta');
        }
        return false;
    }

}