<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use common\models\User;

/**
 * Class LoginCest
 */
class LoginCest
{
    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ];
    }

    public function _before(FunctionalTester $I)
    {
        $authManager = \Yii::$app->authManager;
        $authManager->assign($authManager->getRole('administrador'), User::findOne(['username' => 'erau'])->id);
    }

    public function validLogin(FunctionalTester $I)
    {
        $I->amOnPage('/login/index');
        $I->see('Inicie sessão para continuar');

        $I->fillField('Login[email]', 'sfriesen@jenkins.info');
        $I->fillField('Login[password]', 'password_0');
        $I->click('button[type="submit"]');

        $I->see('erau', 'a');
    }

    public function checkEmpty(FunctionalTester $I)
    {
        $I->amOnPage('/login/index');
        $I->submitForm('#login-form', ['Login' => ['email' => '', 'password' => '']]);
        $I->seeValidationError('Campo obrigatório');
        $I->seeValidationError('Campo obrigatório');
    }
}
