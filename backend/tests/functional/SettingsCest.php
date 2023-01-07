<?php


namespace backend\tests\Functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use common\models\User;

class SettingsCest
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

    public function testChangePassword(FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findOne(['username' => 'administrador'])->id);
        $I->amOnPage('/dashboard/index');

        $I->click('administrador');
        $I->see("Alterar Palavra-Passe");

        $I->fillField('ChangePasswordForm[old_password]', 'password_0');
        $I->fillField('ChangePasswordForm[new_password]', 'novaPassword_0');
        $I->fillField('ChangePasswordForm[repeat_password]', 'novaPassword_0');

        $I->click('Alterar');

        $I->dontSee('Palavra-passe antiga incorreta');
    }
}
