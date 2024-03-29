<?php


namespace backend\tests\Functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use common\models\Empresa;
use common\models\User;
use PHPUnit\Framework\Assert;

class UserCest
{

    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ],
        ];
    }
    public function _before(FunctionalTester $I)
    {
        $authManager = \Yii::$app->authManager;
        $authManager->assign($authManager->getRole('administrador'), User::findOne(['username' => 'administrador'])->id);
        $authManager->assign($authManager->getRole('operadorLogistica'), User::findOne(['username' => 'operador'])->id);
        $authManager->assign($authManager->getRole('funcionario'), User::findOne(['username' => 'funcionario'])->id);

        if(Empresa::find()->count() == 0)
        {
            $empresa = new Empresa();
            $empresa->id = 1;
            $empresa->nome = "Empresa de teste";
            $empresa->NIF = "123123123";
            $empresa->rua = "Rua de teste";
            $empresa->codigoPostal = "2400-000";
            $empresa->localidade = "Leiria";
            $empresa->save();
        }
    }

    public function criarNovoUtilizador(FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findOne(['username' => 'administrador'])->id);
        $I->amOnPage('/dashboard/index');

        $I->click('Utilizadores');
        $I->click('Registar');

        $I->see('Registar Utilizador');
        $I->fillField('Utilizador[username]', 'Funcionario teste');
        $I->fillField('Utilizador[email]', 'user@itassets.pt');
        $I->selectOption('Utilizador[role]', 'funcionario');
        $I->click('Guardar');

        $I->see('Gestão de Utilizadores');
    }

    public function criarNovoUtilizadorInvalido(FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findOne(['username' => 'administrador'])->id);
        $I->amOnPage('/dashboard/index');

        $I->click('Utilizadores');
        $I->click('Registar');

        $count = User::find()->count();

        $I->see('Registar Utilizador');
        $I->click('Guardar');

        $I->see('Campo Obrigatório');

        Assert::assertTrue(User::find()->count() == $count); // Confirmar que não foi criado
    }
}
