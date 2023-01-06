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
        $authManager->assign($authManager->getRole('administrador'), User::findOne(['username' => 'administrador'])->id);
    }

    public function validLogin(FunctionalTester $I)
    {
        $I->amOnPage('/login/index');
        $I->see('Inicie sessão para continuar');

        $I->fillField('Login[email]', 'admin@itassets.pt');
        $I->fillField('Login[password]', 'password_0');
        $I->click('button[type="submit"]');

        $I->see('administrador', 'a');
    }

    public function checkEmpty(FunctionalTester $I)
    {
        $I->amOnPage('/login/index');
        $I->click('button[type="submit"]');
        $I->see('Campo obrigatório', '.invalid-feedback');
    }

    public function checkWrongLogin(FunctionalTester $I)
    {
        $I->amOnPage('/login/index');

        $I->fillField('Login[email]', 'admin@itassets.pt');
        $I->fillField('Login[password]', 'passworderrada');
        $I->click('button[type="submit"]');

        $I->see('Credenciais incorretas', '.invalid-feedback');
    }

    public function checkNoAccessLogin(FunctionalTester $I)
    {
        $authManager = \Yii::$app->authManager;
        $authManager->assign($authManager->getRole('funcionario'), User::findOne(['username' => 'funcionario'])->id);

        $I->amOnPage('/login/index');
        $I->fillField('Login[email]', 'funcionario@itassets.pt');
        $I->fillField('Login[password]', 'password_0');
        $I->click('button[type="submit"]');

        $I->see('Permissões insuficientes', '.invalid-feedback');
    }
}
