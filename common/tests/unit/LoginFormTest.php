<?php

namespace unit;

use Codeception\Test\Unit;
use common\fixtures\UserFixture;
use common\models\Login;
use common\models\User;
use common\tests\UnitTester;
use Yii;

/**
 * Login form test
 */
class LoginFormTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;


    /**
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }

    protected function _before()
    {
        $authmanager = Yii::$app->authManager;
        $authmanager->assign($authmanager->getRole('administrador'), User::findOne(['username' => 'administrador'])->id);
    }


    public function testLoginNoUser()
    {
        $model = new Login([
            'email' => 'not_existing_username@itassets.pt',
            'password' => 'not_existing_password',
        ]);

        verify($model->loginUser([Yii::$app->authManager->getRole('funcionario')]))->false();
        verify(Yii::$app->user->isGuest)->true();
    }

    public function testLoginWrongPassword()
    {
        $model = new Login([
            'email' => 'admin@itassets.pt',
            'password' => '12345678',
        ]);

        verify($model->loginUser([Yii::$app->authManager->getRole('administrador')]))->false();
        verify(Yii::$app->user->isGuest)->true();
    }

    public function testLoginCorrect()
    {
        $model = new Login([
            'email' => 'admin@itassets.pt',
            'password' => 'password_0',
        ]);

        verify($model->loginUser([Yii::$app->authManager->getRole('administrador')]))->true();
        verify(Yii::$app->user->isGuest)->false();
    }
}
