<?php


namespace backend\tests\Acceptance;

use backend\models\Utilizador;
use backend\tests\AcceptanceTester;
use common\models\User;

class ReparacaoCest
{
    public function _before(AcceptanceTester $I)
    {
        $user_aceitacao = User::findOne(['email' => 'aceitacao@itassets.pt']);
        if($user_aceitacao == null)
        {
            // Criar utilizador necessário para executar o teste
            $user_aceitacao = new Utilizador();
            $user_aceitacao->username = "Aceitação";
            $user_aceitacao->email = "aceitacao@itassets.pt";
            $user_aceitacao->role = "administrador";
            $user_aceitacao->createUser(true);
        }
        else
        {
            $user_aceitacao->status = User::STATUS_ACTIVE;
            $user_aceitacao->save();
        }
    }

    public function _after(AcceptanceTester $I)
    {
        $user_aceitacao = User::findOne(['email' => 'aceitacao@itassets.pt']);
        $user_aceitacao->status = User::STATUS_INACTIVE;
        $user_aceitacao->save();
    }

    public function testPercursoReparacao(AcceptanceTester $I)
    {
        //Pagina Inicial do backofficie
        $I->amOnPage('/login/index');
        $I->fillField('Login[email]','aceitacao@itassets.pt'); //preenche os dados nos campos
        $I->fillField('Login[password]','password123');
        $I->wait(5);// = sleep
        $I->click('Iniciar Sessão');// da login

        $I->wait(5);
        $I->amOnPage('/item/index');
        $I->wait(5);

        //Create item
        $I->amOnPage('/item/create');
        $I->fillField('Item[nome]','Nitendo Switch da Ines');
        $I->fillField('Item[serialNumber]','917576143');
        $I->fillField('Item[notas]','O rato nao funciona');
        $I->wait(5);
        $I->click('Guardar');
        $I->wait(5);

        $url_item= $I->grabFromCurrentUrl();
        $Item_id = explode("/", $url_item);

        //Pagina Inicial Item
        $I->amOnPage('/item/index');
        $I->wait(5);

        //Editar Item
        $I->amOnPage('/item/update/'. end($Item_id));
        $I->wait(5);
        $I->fillField('Item[nome]','Fones da Ines');
        $I->fillField('Item[notas]','Os fones nao funcionam');
        $I->click('Guardar');
        $I->wait(10);

        //Alocar  Item
        $I->amOnPage('/pedidoalocacao/index');
        $I->wait(5);
        $I->click('Alocar');
        $I->wait(5);

        //Fazer Pedido de Alocacao
        $I->click('Selecionar Objeto');
        $I->wait(3);
        $I->selectOption('#radiobtn','Item_'.end($Item_id));
        $I->wait(3);
        $I->click('Guardar Seleção');
        $I->wait(5);
        $I->fillField('PedidoAlocacao[obs]','E da HP, ja caiu 3 vezes no chao');//preenche os dados nos campos
        $I->click('Alocar');
        $I->wait(5);
        $url_alocacao= $I->grabFromCurrentUrl();
        $Alocacao_id = explode("/", $url_alocacao);

        //Reparação de um Item
        $I->amOnPage('/pedidoreparacao/index');
        $I->wait(5);
        $I->click('Reparação');
        $I->wait(5);

        //Fazer Pedido de Reparação
        $I->fillField('PedidoReparacao[descricaoProblema]','O rato morreu');//preenche os dados nos campos
        $I->wait(3);
        $I->click('Continuar');
        $I->wait(3);
        $I->click('Selecionar Objetos');
        $I->selectOption('#checkbox','Item_'.end($Item_id));
        $I->click('Guardar Seleção');
        $I->wait(3);
        $I->click('Guardar');
        $I->wait(10);

        //Addicionar despesa
        $I->click('Adicionar despesa');
        $I->wait(2);
        $I->fillField('LinhaDespesasReparacao[descricao]','Comprar pelicula');
        $I->fillField('#linhadespesasreparacao-quantidade-disp','2');
        $I->fillField('#linhadespesasreparacao-preco-disp','20');
        $I->wait(5);
        $I->click('Guardar');

        $I->wait(5);
        $I->click('Finalizar');
        $I->wait(5);

        $I->fillField('PedidoReparacao[respostaObs]','A ines vendeu a nitendo para comprar 4 jantes de um carro');
        $I->wait(3);
        $I->click('Finalizar Pedido de Reparação');
        $I->wait(5);

        $I->amOnPage('/pedidoalocacao/'.end($Alocacao_id));
        $I->wait(3);
        $I->click("Devolver");
    }
}
