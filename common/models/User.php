<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\rbac\Role;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property PedidoAlocacao[] $pedidosAlocacaoAsAprover
 * @property PedidoAlocacao[] $pedidosAlocacaoAsRequester
 * @property PedidoReparacao[] $pedidosReparacaoAsAprover
 * @property PedidoReparacao[] $pedidosReparacaoAsRequester
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required', 'message' => 'Campo Obrigatório'], // Campos obrigatórios
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'O E-Mail indicado já está em uso'],
            [['username', 'email'], 'string', 'min' => 2, 'max' => 255],
            ['email', 'email'], // validação de email
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Nome de Utilizador',
            'password' => 'Palavra-Passe',
            'email' => 'E-Mail'
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['auth_key'], $fields['password_hash'], $fields['password_reset_token'], $fields['verification_token']);
        $fields['role'] = function ()
        {
            return array_keys(Yii::$app->authManager->getRolesByUser($this->id))[0];
        };
        return $fields;
    }


    /**
     * Devikve uma span com o HTML indicado para apresentação da role
     * @return string
     */
    public function getStatusLabel()
    {
        switch ($this->status)
        {
            case self::STATUS_ACTIVE:
                return '<span class="badge badge-success">Ativo</span>';

            case self::STATUS_DELETED:
                return '<span class="badge badge-danger">Removido</span>';

            case self::STATUS_INACTIVE:
                return '<span class="badge badge-warning">Desativado</span>';

            default:
                return '<span class="badge badge-info">' . $this->status . '</span>';
        }
    }

    /**
     * Devolve a role do utilizador
     * @return mixed|Role
     */
    public function getRole()
    {
        return array_values(Yii::$app->authManager->getRolesByUser($this->id))[0];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * Gerar Token
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Gets query for [[PedidosAlocacaoAsAprover]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidosAlocacaoAsAprover()
    {
        return $this->hasMany(PedidoAlocacao::class, ['aprovador_id' => 'id']);
    }

    /**
     * Gets query for [[PedidosAlocacaoAsRequester]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidosAlocacaoAsRequester()
    {
        return $this->hasMany(PedidoAlocacao::class, ['requerente_id' => 'id']);
    }

    /**
     * Gets query for [[PedidosReparacaoAsRequester]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidosReparacaoAsRequester()
    {
        return $this->hasMany(PedidoReparacao::class, ['requerente_id' => 'id']);
    }

    /**
     * Gets query for [[PedidosReparacaoAsAprover]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidosReparacaoAsAprover()
    {
        return $this->hasMany(PedidoReparacao::class, ['responsavel_id' => 'id']);
    }
}
