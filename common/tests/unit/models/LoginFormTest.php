<?php

namespace common\tests\unit\models;

use Codeception\Test\Unit;
use common\tests\UnitTester;
use Yii;
use common\models\Login;
use common\fixtures\UserFixture;

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

    public function testLoginNoUser()
    {
        // TODO: Corrigir código para funcionar com o novo sistema de autenticação
        $model = new Login([
            'username' => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);

        verify($model->loginUser([Yii::$app->authManager->getRole('funcionario')]))->false();
        verify(Yii::$app->user->isGuest)->true();
    }

    public function testLoginWrongPassword()
    {
        // TODO: Corrigir código para funcionar com o novo sistema de autenticação
//        $model = new Login([
//            'username' => 'bayer.hudson',
//            'password' => 'wrong_password',
//        ]);
//
//        verify($model->login())->false();
//        verify( $model->errors)->arrayHasKey('password');
//        verify(Yii::$app->user->isGuest)->true();
    }

    public function testLoginCorrect()
    {
//        // TODO: Corrigir código para funcionar com o novo sistema de autenticação
//        $model = new Login([
//            'username' => 'bayer.hudson',
//            'password' => 'password_0',
//        ]);
//
//        verify($model->loginUser([Yii::$app->authManager->getRole('administrador')]))->true();
//        verify($model->errors)->arrayHasNotKey('password');
//        verify(Yii::$app->user->isGuest)->false();
    }
}
