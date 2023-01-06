<?php


namespace backend\tests\Functional;

use backend\models\Utilizador;
use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use common\models\User;

class UserCest
{

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

    public function criarNovoUtilizador(FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findOne(['username' => 'administrador'])->id);
        $I->amOnPage('/utilizador/create');

        $I->see('Registar Utilizador');

        $I->fillField('Utilizador[username]', 'Funcionario teste');
        $I->fillField('Utilizador[email]', 'user@itassets.pt');
        $I->selectOption('Utilizador[role]', 'funcionario');
        $I->click('Guardar');

        $I->seeCurrentUrlEquals('/utilizador/index');
        $I->see('Gestão de Utilizadores');
    }
}
