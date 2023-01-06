<?php


namespace common\tests\Unit;

use Codeception\Test\Unit;
use common\models\Site;
use common\tests\UnitTester;

class siteTest extends Unit
{
    protected function _before()
    {
    }

    // tests

    /**
     * Validação dos Campos
     **/

    //Campo Nome
    public function testCampoNomeAdd()
    {
        $testSite = new Site();

        $testSite->nome = "Apartado 4133";
        $this->assertTrue($testSite->validate(['nome']));
    }

    public function testCampoNomeNull()
    {
        $testSite = new Site();

        $testSite->nome = null;
        $this->assertFalse($testSite->validate(['nome']));
    }

    public function testCampoNomeEmpty()
    {
        $testSite = new Site();

        $testSite->nome = "";
        $this->assertFalse($testSite->validate(['nome']));
    }

    public function testCampoNomeMax()
    {
        $testSite = new Site();

        $testSite->nome = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                           Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown 
                           printer took a galley of type and scrambled it to make a type specimen book.";
        $this->assertFalse($testSite->validate(['nome']));
    }

    //Campo Notas
    public function testCampoNotasAdd()
    {
        $testSite = new Site();

        $testSite->notas = "Lorem Ipsum is simply dummy text of the printing and typesetting industry.";
        $this->assertTrue($testSite->validate(['notas']));
    }

    public function testCampoNotasNull()
    {
        $testSite = new Site();

        $testSite->notas = null;
        $this->assertTrue($testSite->validate(['notas']));
    }

    //Campo Localidade
    public function testCampoLocalidadeAdd()
    {
        $testSite = new Site();

        $testSite->localidade = "Leiria";
        $this->assertTrue($testSite->validate(['localidade']));
    }

    public function testCampoLocalidadeNull()
    {
        $testSite = new Site();

        $testSite->localidade = null;
        $this->assertTrue($testSite->validate(['localidade']));
    }

    public function testCampoLocalidadeEmpty()
    {
        $testSite = new Site();

        $testSite->localidade = "";
        $this->assertTrue($testSite->validate(['localidade']));
    }

    public function testCampoLocalidadeMax()
    {
        $testSite = new Site();

        $testSite->localidade = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                                   Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown 
                                   printer took a galley of type and scrambled it to make a type specimen book.";
        $this->assertFalse($testSite->validate(['localidade']));
    }

    //Campo Rua
    public function testCampoRuaAdd()
    {
        $testSite = new Site();

        $testSite->rua = "Rua General Norton de Matos";
        $this->assertTrue($testSite->validate(['rua']));
    }

    public function testCampoRuaNull()
    {
        $testSite = new Site();

        $testSite->rua = null;
        $this->assertTrue($testSite->validate(['rua']));
    }

    public function testCampoRuaEmpty()
    {
        $testSite = new Site();

        $testSite->rua = "";
        $this->assertTrue($testSite->validate(['rua']));
    }

    public function testCampoRuaMax()
    {
        $testSite = new Site();

        $testSite->rua = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                          Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown 
                          printer took a galley of type and scrambled it to make a type specimen book.";
        $this->assertFalse($testSite->validate(['rua']));
    }

    //Campo Coordenadas
    public function testCampoCoordenadasAdd()
    {
        $testSite = new Site();

        $testSite->coordenadas = "39.735692, -8.820847";
        $this->assertTrue($testSite->validate(['coordenadas']));
    }

    public function testCampoCoordenadasNull()
    {
        $testSite = new Site();

        $testSite->coordenadas = null;
        $this->assertTrue($testSite->validate(['coordenadas']));
    }

    public function testCampoCoordenadasEmpty()
    {
        $testSite = new Site();

        $testSite->coordenadas = "";
        $this->assertTrue($testSite->validate(['coordenadas']));
    }

    public function testCampoCoordenadasMax()
    {
        $testSite = new Site();

        $testSite->coordenadas = "39.735692, -8.820847 39.735692, -8.820847 39.735692, -8.820847 
                                  39.735692, -8.82084739.735692, -8.82084739.735692, -8.820847
                                  39.735692, -8.82084739.735692, -8.82084739.735692, -8.820847 39.735692, -8.820847";
        $this->assertFalse($testSite->validate(['coordenadas']));
    }

    //Campo Código Postal
    public function testCampoCodPostalAdd()
    {
        $testSite = new Site();

        $testSite->codPostal = "2411-901";
        $this->assertTrue($testSite->validate(['codPostal']));
    }

    public function testCampoCodPostalNull()
    {
        $testSite = new Site();

        $testSite->codPostal = null;
        $this->assertTrue($testSite->validate(['codPostal']));
    }

    public function testCampoCodPostalEmpty()
    {
        $testSite = new Site();

        $testSite->codPostal = "";
        $this->assertTrue($testSite->validate(['codPostal']));
    }

    public function testCampoCodPostalMax()
    {
        $testSite = new Site();

        $testSite->codPostal = "2411-2512";
        $this->assertFalse($testSite->validate(['codPostal']));
    }

    /**
     * Validação do Registo
     **/
    public function testRegistoSite(){
        $site = new Site();

        $site->nome = 'Porto';
        $site->rua = 'Rua das Flores';
        $site->localidade = 'Porto';
        $site->codPostal = '2415-542';
        $site->coordenadas = '39.735692, -8.820847';
        $site->notas = null;
        $site->save();

        $this->assertNotNull(Site::findOne(['id' => $site->id]));
    }

    /**
     * Validação da Edição
     **/
    public function testEdicaoSite(){
        $site = new Site();

        $site->nome = "Porto";
        $site->rua = "Rua das Flores";
        $site->localidade = "Porto";
        $site->codPostal = "2415-542";
        $site->coordenadas = "39.735692, -8.820847";
        $site->notas = null;
        $site->save();

        $this->assertNotNull(Site::findOne(['id' => $site->id]));

        $site->nome = "Leiria";
        $site->save();

        $this->assertEquals(Site::findOne(['id' => $site->id])->nome, $site->nome);

    }

    /**
     * Validação de Eliminação
     **/
    public function testEliminacaoSite(){
        $site = new Site();

        $site->nome = "Porto";
        $site->rua = "Rua das Flores";
        $site->localidade = "Porto";
        $site->codPostal = "2415-542";
        $site->coordenadas = "39.735692, -8.820847";
        $site->notas = null;
        $site->save();

        $this->assertNotNull(Site::findOne(['id' => $site->id]));
        $test_id = $site->id;
        $site->delete();

        $this->assertNull(Site::findOne([$test_id]));
    }
}

