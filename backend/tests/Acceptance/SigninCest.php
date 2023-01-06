<?php


namespace backend\tests\Acceptance;

use backend\tests\AcceptanceTester;

class SigninCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
    }

    public function AcceptanceTest(AcceptanceTester $I)
    {
        //Pagina Inicial do backofficie
        $I->amOnPage('/login/index');
        $I->fillField('Login[email]','tiago@gmail.com');//preenche os dados nos campos
        $I->fillField('Login[password]','Password123');
        $I->wait(5);// = sleep
        $I->click('button[type="submit"]');// da login

        //Index do Item

        $I->wait(5);
        $I->amOnPage('/item/index');
        $I->wait(5);

        //Create item

        $I->amOnPage('/item/create');

        $I->fillField('Item[nome]','Nitendo Switch da Ines 6');
        $I->fillField('Item[serialNumber]','917576143');
        $I->fillField('Item[notas]','O rato nao funciona');
        $I->wait(5);
        $I->click('Guardar');
        $I->wait(5);
        $url = $I->grabFromCurrentUrl();

        $Item_id = explode("/", $url);

        $I->wait(5);
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
        $I->amOnPage('/pedidoalocacao/index');
        $I->wait(5);


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

        //ADdicionar despesa


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
        $I->amOnPage('/pedidoalocacao/10');
        $I->wait(3);
        $I->click("Devolver");
        $I->wait(10);

        //$I->amOnPage('/item/index');

    }
}
