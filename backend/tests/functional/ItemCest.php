<?php


namespace backend\tests\Functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use common\models\Empresa;
use common\models\Item;
use common\models\User;
use PHPUnit\Framework\Assert;

class ItemCest
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

    public function testRegistarItem(FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findOne(['username' => 'administrador'])->id);
        $I->amOnPage('/dashboard/index');

        $I->click('Itens');
        $I->click('Registar');

        $I->fillField('Item[nome]', 'Item de teste registo');
        $I->fillField('Item[serialNumber]', 'TEST123');
        $I->click('Guardar');

        $I->see('Item de teste registo');
    }

    public function testRegistarItemInvalido(FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findOne(['username' => 'administrador'])->id);
        $I->amOnPage('/dashboard/index');

        $count = Item::find()->count();

        $I->click('Itens');
        $I->click('Registar');
        $I->click('Guardar');

        $I->see('Nome cannot be blank.');

        Assert::assertTrue(Item::find()->count() == $count); //Para validar que não foi mesmo criado um novo objeto
    }
}
