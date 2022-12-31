<?php

namespace common\models;

use PhpMqtt\Client\Exceptions\ConfigurationInvalidException;
use PhpMqtt\Client\Exceptions\ConnectingToBrokerFailedException;
use PhpMqtt\Client\Exceptions\DataTransferException;
use PhpMqtt\Client\Exceptions\ProtocolNotSupportedException;
use PhpMqtt\Client\Exceptions\RepositoryException;
use PhpMqtt\Client\MqttClient;
use Yii;
use yii\web\ServerErrorHttpException;

/**
 * This is the model class for table "notificacoes".
 *
 * @property int $id
 * @property int $user_id
 * @property string $message
 * @property string|null $link
 * @property string|null $datetime
 * @property int|null $read
 *
 * @property User $user
 */
class Notificacoes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notificacoes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'message'], 'required'],
            [['user_id', 'read'], 'integer'],
            [['message'], 'string'],
            [['datetime'], 'safe'],
            [['link'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'message' => 'Mensagem',
            'link' => 'Link',
            'datetime' => 'Data/Hora',
            'read' => 'Read',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Guarda a notificação na base de dados e envia via MQTT em formarto JSON
     * @param $userID int ID do utilizador a quem enviar a notificação
     * @param $message string Mensagem da notificação
     * @param $link string|null Link da notificação
     * @return void
     * @throws ServerErrorHttpException
     * @throws ConfigurationInvalidException
     * @throws ConnectingToBrokerFailedException
     * @throws DataTransferException
     * @throws ProtocolNotSupportedException
     * @throws RepositoryException
     */
    public static function addNotification(int $userID, string $message, string $link = null): void
    {
        $model = new Notificacoes();
        $model->user_id = $userID;
        $model->message = $message;
        $model->link = $link;

        if($model->save())
        {
            $mqtt = new MqttClient("127.0.0.1", 1883, "SERVER");
            $mqtt->connect();
            $mqtt->publish("USER_" . $userID . "_TOPIC", json_encode(['message' => $message, 'link' => $link], 0));
            $mqtt->disconnect();
        }
        else
        {
            throw new ServerErrorHttpException("Erro ao guardar notificação.");
        }
    }
}
