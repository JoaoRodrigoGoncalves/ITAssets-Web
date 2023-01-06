<?php


namespace common\tests\Unit;

use common\models\Categoria;
use common\models\Grupoitens;
use common\models\GruposItens_Item;
use common\models\Item;
use common\models\Site;
use common\tests\UnitTester;

class grupoItens_ItemTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    //Campo grupoItems_id
    public function testCampoGrupoItensIDAdd(){
        /* Grupo de Itens */
        $newGrupoItensTeste = new Grupoitens();

        $newGrupoItensTeste->status=10;
        $newGrupoItensTeste->nome="Componentes";
        $newGrupoItensTeste->notas=null;
        $newGrupoItensTeste->save();

        $testGruposItens_Item = new GruposItens_Item();

        $testGruposItens_Item->grupoItens_id = $newGrupoItensTeste->id;
        $this->assertTrue($testGruposItens_Item->validate(['grupoItens_id']));
    }

    public function testCampoGrupoItensIDNull(){
        $testGruposItens_Item = new GruposItens_Item();
        $testGruposItens_Item->grupoItens_id = null;
        $this->assertFalse($testGruposItens_Item->validate(['grupoItens_id']));
    }

    //Campo items_id
    public function testCampoItemIDAdd(){
        $newItemTeste = new Item();
        $newItemTeste->status = Item::STATUS_ACTIVE;
        $newItemTeste->nome = "Componentes";
        $newItemTeste->serialNumber = "dsc564sdsdS";
        $newItemTeste->site_id = null;
        $newItemTeste->categoria_id = null;
        $newItemTeste->notas = null;
        $newItemTeste->save();

        $testGruposItens_Item = new GruposItens_Item();

        $testGruposItens_Item->item_id = $newItemTeste->id;
        $this->assertTrue($testGruposItens_Item->validate(['item_id']));
    }

    public function testCampoItemIDNull(){
        $testGruposItens_Item = new GruposItens_Item();
        $testGruposItens_Item->item_id = null;
        $this->assertFalse($testGruposItens_Item->validate(['item_id']));
    }

    /**
     * Validação do Registo
     **/
    public function testRegistoGrupoItensItem(){
        //Itens
        $newItemTeste = new Item();

        $newItemTeste->status = Item::STATUS_ACTIVE;
        $newItemTeste->nome = "ASUS VivoBook 15";
        $newItemTeste->serialNumber = "dsc564sdsdS";
        $newItemTeste->site_id = null;
        $newItemTeste->categoria_id = null;
        $newItemTeste->notas = null;
        $newItemTeste->save();

        $newItemTeste2 = new Item();

        $newItemTeste2->status = Item::STATUS_ACTIVE;
        $newItemTeste2->nome = "Samsung A02";
        $newItemTeste2->serialNumber = "sdfw5a7ea5w";
        $newItemTeste2->site_id = null;
        $newItemTeste2->categoria_id = null;
        $newItemTeste2->notas = null;
        $newItemTeste2->save();

        /* Grupo Itens */
        $newGrupoItensTeste = new Grupoitens();

        $newGrupoItensTeste->status = Grupoitens::STATUS_ACTIVE;
        $newGrupoItensTeste->nome = "Computadores";
        $newGrupoItensTeste->notas = null;
        $newGrupoItensTeste->save();

        /* Itens de um Grupo Itens */
        $grupoItensItem = new GruposItens_Item();

        $grupoItensItem->item_id = $newItemTeste->id;
        $grupoItensItem->grupoItens_id = $newGrupoItensTeste->id;
        $grupoItensItem->save();

        $this->assertNotNull(GruposItens_Item::findOne(['item_id' => $grupoItensItem->item_id]));

        $grupoItensItem->item_id = $newItemTeste2->id;
        $grupoItensItem->grupoItens_id = $newGrupoItensTeste->id;
        $grupoItensItem->save();

        $this->assertNotNull(GruposItens_Item::findOne(['item_id' => $grupoItensItem->item_id]));
    }
}
