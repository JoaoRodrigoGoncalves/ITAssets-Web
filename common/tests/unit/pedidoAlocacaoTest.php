<?php


namespace common\tests\Unit;

use Codeception\Test\Unit;
use common\fixtures\UserFixture;
use common\models\Grupoitens;
use common\models\Item;
use common\models\PedidoAlocacao;
use common\models\User;
use common\tests\UnitTester;
use Yii;

class pedidoAlocacaoTest extends Unit
{

    protected UnitTester $tester;

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

    protected function _before()
    {
        $authmanager = Yii::$app->authManager;
        $authmanager->assign($authmanager->getRole('administrador'), User::findOne(['username' => 'administrador'])->id);
    }

    // tests

    //Campo status
    public function testCampoStatusInt()
    {
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->status = "Status Aprovado";
        $this->assertFalse($testPedidoAlocacao->validate(['status']));
    }

    //Campo item_id
    public function testCampoItemIDInt(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->item_id = "componentes";
        $this->assertFalse($testPedidoAlocacao->validate(['item_id']));
    }

    public function testCampoItemIDAdd(){
        /* Item */
        $newItemTeste = new Item();
        $newItemTeste->status = Item::STATUS_ACTIVE;
        $newItemTeste->nome = "Componentes";
        $newItemTeste->serialNumber = "dsc564sdsdS";
        $newItemTeste->site_id = null;
        $newItemTeste->categoria_id = null;
        $newItemTeste->notas = null;
        $newItemTeste->save();

        /* Pedido de Alocação */
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->item_id = $newItemTeste->id;
        $this->assertTrue($testPedidoAlocacao->validate(['item_id']));
    }

    public function testCampoItemIDNull(){
        //Se o Item for null é obrigatório colocar um grupo de itens
        $testPedidoAlocacao = new PedidoAlocacao();
        $testPedidoAlocacao->item_id = null;

        $this->assertFalse($testPedidoAlocacao->validate(['item_id']));
    }

    //Campo grupoItem_id
    public function testCampoGrupoItensIDInt(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->grupoItem_id = "Componentes";
        $this->assertFalse($testPedidoAlocacao->validate(['grupoItem_id']));
    }

    public function testCampoGrupoItensIDAdd(){
        /* Grupo de Itens */
        $newGrupoItensTeste = new Grupoitens();

        $newGrupoItensTeste->status=10;
        $newGrupoItensTeste->nome="Componentes";
        $newGrupoItensTeste->notas=null;
        $newGrupoItensTeste->save();

        /* Pedido de Alocação */
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->grupoItem_id = $newGrupoItensTeste->id;
        $this->assertTrue($testPedidoAlocacao->validate(['grupoItem_id']));
    }

    public function testCampoGrupoItensIDNull(){
        //Se o Grupo de Itens for null é obrigatório colocar um Item
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->grupoItem_id = null;
        $this->assertFalse($testPedidoAlocacao->validate(['grupoItem_id']));
    }

    //Campo requerente_id
    public function testCampoRequerenteIDInt(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->requerente_id = "Administrador";
        $this->assertFalse($testPedidoAlocacao->validate(['requerente_id']));
    }

    public function testCampoRequerenteIDAdd(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->requerente_id = User::findOne(['username' => 'administrador'])->id;
        $this->assertTrue($testPedidoAlocacao->validate(['requerente_id']));
    }

    public function testCampoRequerenteIDNull(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->requerente_id = null;
        $this->assertFalse($testPedidoAlocacao->validate(['requerente_id']));
    }

    //Campo aprovador_id
    public function testCampoAprovadorIDInt(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->aprovador_id = "Administrador";
        $this->assertFalse($testPedidoAlocacao->validate(['aprovador_id']));
    }

    public function testCampoAprovadorIDAdd(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->aprovador_id = User::findOne(['username' => 'administrador'])->id;
        $this->assertTrue($testPedidoAlocacao->validate(['aprovador_id']));
    }

    //Campo dataPedido
    public function testCampoDataPedidoDateTime(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->dataPedido = "2023";
        $this->assertFalse($testPedidoAlocacao->validate(['dataPedido']));
    }

    //Campo dataInicio
    public function testCampoDataInicioDateTime(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->dataInicio = "Inicio";
        $this->assertFalse($testPedidoAlocacao->validate(['dataInicio']));
    }

    public function testCampoDataInicioAdd(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->dataInicio = "2023-01-07 14:54:00";
        $this->assertTrue($testPedidoAlocacao->validate(['dataInicio']));
    }

    public function testCampoDataInicioNull(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->dataInicio = null;
        $this->assertTrue($testPedidoAlocacao->validate(['dataInicio']));
    }

    //Campo dataFim
    public function testCampoDataFimDateTime(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->dataFim = "Fim";
        $this->assertFalse($testPedidoAlocacao->validate(['dataFim']));
    }

    public function testCampoDataFimAdd(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->dataFim = "2023-01-07 17:26:00";
        $this->assertTrue($testPedidoAlocacao->validate(['dataFim']));
    }

    public function testCampoDataFimNull(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->dataFim = null;
        $this->assertTrue($testPedidoAlocacao->validate(['dataFim']));
    }

    //Campo obs
    public function testCampoObsAdd(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->obs = "Pedido dos Itens seguintes para a sala B";
        $this->assertTrue($testPedidoAlocacao->validate(['obs']));
    }

    public function testCampoObsNull(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->obs = null;
        $this->assertTrue($testPedidoAlocacao->validate(['obs']));
    }

    public function testCampoObsEmpty(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->obs = "";
        $this->assertTrue($testPedidoAlocacao->validate(['obs']));
    }

    //Campo obsResposta
    public function testCampoObsRespostaAdd(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->obsResposta = "Concluído";
        $this->assertTrue($testPedidoAlocacao->validate(['obsResposta']));
    }

    public function testCampoObsRespostaNull(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->obsResposta = null;
        $this->assertTrue($testPedidoAlocacao->validate(['obsResposta']));
    }

    public function testCampoObsRespostaEmpty(){
        $testPedidoAlocacao = new PedidoAlocacao();

        $testPedidoAlocacao->obsResposta = "";
        $this->assertTrue($testPedidoAlocacao->validate(['obsResposta']));
    }

    /**
     * Registar Pedido Alocação com item_id
     **/
    public function testRegistoPedidoAlocacaoItemID(){
        //Item
        $item = new Item();

        $item->nome = 'ASUS VivoBook 15';
        $item->serialNumber = '16rg1esra85af';
        $item->categoria_id = null;
        $item->site_id = null;
        $item->notas = null;
        $item->save();

        //Pedido Alocação
        $alocacao = new PedidoAlocacao();

        $alocacao->status = PedidoAlocacao::STATUS_APROVADO;
        $alocacao->dataPedido = "2023-01-05 15:26:21";
        $alocacao->dataInicio= null;
        $alocacao->dataFim = null;
        $alocacao->requerente_id = User::findOne(['username' => 'administrador'])->id;
        $alocacao->aprovador_id = null;
        $alocacao->item_id = $item->id;
        $alocacao->grupoItem_id = null;
        $alocacao->obsResposta = null;
        $alocacao->obs = "Pedido de Alocação";
        $alocacao->save();

        $this->assertNotNull(PedidoAlocacao::findOne(['id' => $alocacao->id]));
    }

    /**
     * Registar Pedido Alocação com grupoItem_id
     **/
    public function testRegistoPedidoAlocacaoGrupoItensID(){
        //Grupo Itens
        $grupoItens = new Grupoitens();

        $grupoItens->nome = 'Itens da Sala B';
        $grupoItens->notas = null;
        $grupoItens->save();

        //Pedido Alocação
        $alocacao = new PedidoAlocacao();

        $alocacao->status = PedidoAlocacao::STATUS_APROVADO;
        $alocacao->dataPedido = "2023-01-05 15:26:21";
        $alocacao->dataInicio= null;
        $alocacao->dataFim = null;
        $alocacao->requerente_id = User::findOne(['username' => 'administrador'])->id;
        $alocacao->aprovador_id = null;
        $alocacao->item_id = null;
        $alocacao->grupoItem_id = $grupoItens->id;
        $alocacao->obsResposta = null;
        $alocacao->obs = "Pedido de Alocação";
        $alocacao->save();

        $this->assertNotNull(PedidoAlocacao::findOne(['id' => $alocacao->id]));
    }

    /**
     * Finaliazar Pedido Alocação
     **/
    public function testFinalizarPedidoAlocacao(){
        //Item
        $item = new Item();

        $item->nome = 'ASUS VivoBook 15';
        $item->serialNumber = '16rg1esra85af';
        $item->categoria_id = null;
        $item->site_id = null;
        $item->notas = null;
        $item->save();

        //Pedido Alocação
        $alocacao = new PedidoAlocacao();

        $alocacao->status = PedidoAlocacao::STATUS_APROVADO;
        $alocacao->dataPedido = "2023-01-05 15:26:21";
        $alocacao->dataInicio= null;
        $alocacao->dataFim = null;
        $alocacao->requerente_id = User::findOne(['username' => 'administrador'])->id;
        $alocacao->aprovador_id = null;
        $alocacao->item_id = $item->id;
        $alocacao->grupoItem_id = null;
        $alocacao->obsResposta = null;
        $alocacao->obs = "Pedido de Alocação";
        $alocacao->save();

        $this->assertNotNull(PedidoAlocacao::findOne(['id' => $alocacao->id]));

        $alocacao->status = PedidoAlocacao::STATUS_DEVOLVIDO;
        $alocacao->save();

        $this->assertEquals(PedidoAlocacao::findOne(["id" => $alocacao->id])->status, $alocacao->status);
    }
}
