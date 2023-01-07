<?php


namespace backend\tests\Functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use common\models\Site;
use common\models\User;
use PHPUnit\Framework\Assert;

class SiteCest
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
    }


    public function testRegistarLocal(FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findOne(['username' => 'administrador'])->id);
        $I->amOnPage('/site/index');

        $I->click('Registar');

        $I->fillField('Site[nome]', 'Localização 1');
        $I->fillField('Site[rua]', 'Rua de teste, Nº8');
        $I->fillField('Site[localidade]', 'Leiria');
        $I->fillField('Site[codPostal]', '2400-000');
        $I->fillField('Site[coordenadas]', '39.749511, -8.807385');
        $I->click('Guardar');

        $I->see('Localização 1');
    }

    public function testRegistarLocalInvalido(FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findOne(['username' => 'administrador'])->id);
        $I->amOnPage('/site/index');

        $count = Site::find()->count();

        $I->click('Registar');
        $I->click('Guardar');

        $I->see('Nome cannot be blank.');

        Assert::assertTrue(Site::find()->count() == $count); // Validar que não foi criado nenhum
    }
}
