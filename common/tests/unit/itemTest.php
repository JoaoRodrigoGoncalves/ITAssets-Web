<?php


namespace common\tests\Unit;

use Codeception\Test\Unit;
use common\models\Categoria;
use common\models\Item;
use common\models\Site;
use common\tests\UnitTester;
use MongoDB\Driver\CursorId;

class itemTest extends Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests

    //Campo Nome
    public function testCampoNomeAdd()
    {
        $testItem = new Item();

        $testItem->nome = "ASUS VivoBook 15";
        $this->assertTrue($testItem->validate(['nome']));
    }

    public function testCampoNomeNull()
    {
        $testItem = new Item();

        $testItem->nome = null;
        $this->assertFalse($testItem->validate(['nome']));
    }

    public function testCampoNomeEmpty()
    {
        $testItem = new Item();

        $testItem->nome = "";
        $this->assertFalse($testItem->validate(['nome']));
    }

    public function testCampoNomeMax()
    {
        $testItem = new Item();

        $testItem->nome = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                           Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer
                           took a galley of type and scrambled it to make a type specimen book.";
        $this->assertFalse($testItem->validate(['nome']));
    }

    //Campo SerialNumber
    public function testCampoSerialNumberAdd()
    {
        $testItem = new Item();

        $testItem->serialNumber = "75ajh6217jah4545fewa5";
        $this->assertTrue($testItem->validate(['serialNumber']));
    }

    public function testCampoSerialNumberNull()
    {
        $testItem = new Item();

        $testItem->serialNumber = null;
        $this->assertTrue($testItem->validate(['serialNumber']));
    }

    public function testCampoSerialNumberMax()
    {
        $testItem = new Item();

        $testItem->serialNumber = "75ajh6217jah4545fewa5hdsbvds5s4c4dsf425654csdv554fd4s4d44s4a365sa4fs11ds54a6d64f68486s4d84f4s546d4afd4v
                                   fdv445rgs5f4g66s64fgd48ser54g4a64f4wr8ga6ef2121s84f9df5df4g4hyjyk4luigfsevvdf4v4989d44s44e8f6s6a131dfhb
                                   ksa4565hbsd";
        $this->assertFalse($testItem->validate(['serialNumber']));
    }

    //Campo Notas

    public function testCampoNotasAdd()
    {
        $testItem = new Item();

        $testItem->notas = "Nota";
        $this->assertTrue($testItem->validate(['notas']));
    }

    public function testCampoNotasNull()
    {
        $testItem = new Item();

        $testItem->notas = null;
        $this->assertTrue($testItem->validate(['notas']));
    }

    public function testCampoNotasMax()
    {
        $testItem = new Item();

        $testItem->notas = "75ajh6217jah4545fewa5hdsbvds5s4c4dsf425654csdv554fd4s4d44s4a365sa4fs11ds54a6d64f68486s4d84f4s546d4afd4v
                            fdv445rgs5f4g66s64fgd48ser54g4a64f4wr8ga6ef2121s84f9df5df4g4hyjyk4luigfsevvdf4v4989d44s44e8f6s6a131dfhb
                            ksa4565hbsd";
        $this->assertFalse($testItem->validate(['notas']));
    }

    //Campo Categoria
    public function testCampoCategoriaAdd(){
        $newCategoriaTeste = new Categoria();

        $newCategoriaTeste->status=10;
        $newCategoriaTeste->nome="Computadores";
        $newCategoriaTeste->save();

        $testItem = new Item();

        $testItem->categoria_id = $newCategoriaTeste->id;
        $this->assertTrue($testItem->validate(['categoria_id']));
    }

    public function testCampoCategoriaNull(){
        $newCategoriaTeste = new Categoria();

        $newCategoriaTeste->status=10;
        $newCategoriaTeste->nome="Computadores";
        $newCategoriaTeste->save();

        $testItem = new Item();

        $testItem->categoria_id = null;
        $this->assertTrue($testItem->validate(['categoria_id']));
    }

    //Campo Site
    public function testCampoSiteAdd()
    {
        $newSiteTeste = new Site();

        $newSiteTeste->nome="Porto";
        $newSiteTeste->rua="Rua das Flores";
        $newSiteTeste->localidade="Porto";
        $newSiteTeste->codPostal="2460-153";
        $newSiteTeste->coordenadas="39.735692, -8.820847";
        $newSiteTeste->notas=null;
        $newSiteTeste->save();

        $testItem = new Item();

        $testItem->site_id = $newSiteTeste->id;
        $this->assertTrue($testItem->validate(['site_id']));
    }

    public function testCampoSiteNull()
    {
        $newSiteTeste = new Site();

        $newSiteTeste->nome="Porto";
        $newSiteTeste->rua="Rua das Flores";
        $newSiteTeste->localidade="Porto";
        $newSiteTeste->codPostal="2460-153";
        $newSiteTeste->coordenadas="39.735692, -8.820847";
        $newSiteTeste->notas=null;
        $newSiteTeste->save();

        $testItem = new Item();

        $testItem->site_id = null;
        $this->assertTrue($testItem->validate(['site_id']));
    }

    /**
     * Validação do Registo
     **/
    public function testRegistoItem(){
        /* Site */
        $newSiteTeste = new Site();

        $newSiteTeste->nome="Porto";
        $newSiteTeste->rua="Rua das Flores";
        $newSiteTeste->localidade="Porto";
        $newSiteTeste->codPostal="2460-153";
        $newSiteTeste->coordenadas="39.735692, -8.820847";
        $newSiteTeste->notas=null;
        $newSiteTeste->save();

        /* Categoria */
        $newCategoriaTeste = new Categoria();

        $newCategoriaTeste->status=10;
        $newCategoriaTeste->nome="Computadores";
        $newCategoriaTeste->save();

        /* Item */
        $item = new Item();

        $item->nome = 'ASUS VivoBook 15';
        $item->serialNumber = '16rg1esra85af';
        $item->categoria_id = $newCategoriaTeste->id;;
        $item->site_id = $newSiteTeste->id;;
        $item->notas = null;
        $item->save();

        $this->assertNotNull(Item::findOne(['id' => $item->id]));
    }

    /**
     * Validação da Edição
     **/
    public function testEdicaoItem(){
        /* Site */
        $newSiteTeste = new Site();

        $newSiteTeste->nome="Porto";
        $newSiteTeste->rua="Rua das Flores";
        $newSiteTeste->localidade="Porto";
        $newSiteTeste->codPostal="2460-153";
        $newSiteTeste->coordenadas="39.735692, -8.820847";
        $newSiteTeste->notas=null;
        $newSiteTeste->save();

        /* Categoria */
        $newCategoriaTeste = new Categoria();

        $newCategoriaTeste->status=10;
        $newCategoriaTeste->nome="Computadores";
        $newCategoriaTeste->save();

        /* Item */
        $item = new Item();

        $item->nome = 'ASUS VivoBook 15';
        $item->serialNumber = '16rg1esra85af';
        $item->categoria_id = $newCategoriaTeste->id;;
        $item->site_id = $newSiteTeste->id;;
        $item->notas = null;
        $item->save();

        $this->assertNotNull(Item::findOne(['id' => $item->id]));

        $item->nome = "Samsung A52 5G";
        $item->save();

        $this->assertEquals(Item::findOne(['id' => $item->id])->nome, $item->nome);

    }

    /**
     * Validação de Eliminação
     **/
    public function testEliminacaoItem(){
        /* Site */
        $newSiteTeste = new Site();

        $newSiteTeste->nome="Porto";
        $newSiteTeste->rua="Rua das Flores";
        $newSiteTeste->localidade="Porto";
        $newSiteTeste->codPostal="2460-153";
        $newSiteTeste->coordenadas="39.735692, -8.820847";
        $newSiteTeste->notas=null;
        $newSiteTeste->save();

        /* Categoria */
        $newCategoriaTeste = new Categoria();

        $newCategoriaTeste->status=10;
        $newCategoriaTeste->nome="Computadores";
        $newCategoriaTeste->save();

        /* Item */
        $item = new Item();

        $item->nome = 'ASUS VivoBook 15';
        $item->serialNumber = '16rg1esra85af';
        $item->categoria_id = $newCategoriaTeste->id;;
        $item->site_id = $newSiteTeste->id;;
        $item->notas = null;
        $item->save();

        $this->assertNotNull(Item::findOne(['id' => $item->id]));

        $item->status = Item::STATUS_DELETED;
        $item->save();

        $this->assertEquals(Item::STATUS_DELETED, Item::findOne([$item->id])->status);
    }
}
