<?php


namespace common\tests\Unit;

use common\models\Empresa;
use common\tests\UnitTester;
use http\Encoding\Stream\Enbrotli;

class empresaTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests

    //Campo Nome
    public function testCampoNomeAdd()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->nome = "Flower Lda.";
        $this->assertTrue($testEmpresa->validate(['nome']));
    }

    public function testCampoNomeNull()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->nome = null;
        $this->assertFalse($testEmpresa->validate(['nome']));
    }

    public function testCampoNomeEmpty()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->nome = "";
        $this->assertFalse($testEmpresa->validate(['nome']));
    }

    public function testCampoNomeMax()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->nome = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                              Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown 
                              printer took a galley of type and scrambled it to make a type specimen book.";
        $this->assertFalse($testEmpresa->validate(['nome']));
    }

    //Campo NIF
    public function testCampoNIFAdd()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->NIF = "658123548";
        $this->assertTrue($testEmpresa->validate(['NIF']));
    }

    public function testCampoNIFNull()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->NIF = null;
        $this->assertFalse($testEmpresa->validate(['NIF']));
    }

    public function testCampoNIFEmpty()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->NIF = "";
        $this->assertFalse($testEmpresa->validate(['NIF']));
    }

    public function testCampoNIFMax()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->NIF = "6458754648";
        $this->assertFalse($testEmpresa->validate(['NIF']));
    }

    //Campo Rua
    public function testCampoRuaAdd()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->rua = "Rua Santo Condestável";
        $this->assertTrue($testEmpresa->validate(['rua']));
    }

    public function testCampoRuaNull()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->rua = null;
        $this->assertFalse($testEmpresa->validate(['rua']));
    }

    public function testCampoRuaEmpty()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->rua = "";
        $this->assertFalse($testEmpresa->validate(['rua']));
    }

    public function testCampoRuaMax()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->rua = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                             Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown 
                             printer took a galley of type and scrambled it to make a type specimen book.";
        $this->assertFalse($testEmpresa->validate(['rua']));
    }

    //Campo Localidade
    public function testCampoLocalidadeAdd()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->localidade = "Leiria";
        $this->assertTrue($testEmpresa->validate(['localidade']));
    }

    public function testCampoLocalidadeNull()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->localidade = null;
        $this->assertFalse($testEmpresa->validate(['localidade']));
    }

    public function testCampoLocalidadeEmpty()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->localidade = "";
        $this->assertFalse($testEmpresa->validate(['localidade']));
    }

    public function testCampoLocalidadeMax()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->localidade = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown 
                                    printer took a galley of type and scrambled it to make a type specimen book.";
        $this->assertFalse($testEmpresa->validate(['localidade']));
    }

    //Campo CodPostal
    public function testCampoCodPostalAdd()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->codigoPostal = "2411-654";
        $this->assertTrue($testEmpresa->validate(['codigoPostal']));
    }

    public function testCampoCodPostalNull()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->codigoPostal = null;
        $this->assertFalse($testEmpresa->validate(['codigoPostal']));
    }

    public function testCampoCodPostalEmpty()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->codigoPostal = "";
        $this->assertFalse($testEmpresa->validate(['codigoPostal']));
    }

    public function testCampoCodPostalMax()
    {
        $testEmpresa = new Empresa();

        $testEmpresa->codigoPostal = "6142-4565";
        $this->assertFalse($testEmpresa->validate(['codigoPostal']));
    }

    /**
     * Validação do Registo
     **/
    public function testRegistoEmpresa(){
        $empresa = new Empresa();

        $empresa->nome = 'Flores Lda.';
        $empresa->rua = 'Rua da Senhora da Esperança';
        $empresa->localidade = 'Leiria';
        $empresa->codigoPostal = '2415-542';
        $empresa->NIF = '156854975';
        $empresa->save();

        $this->assertNotNull(Empresa::findOne(['id' => $empresa->id]));
    }

    /**
     * Validação da Edição
     **/
    public function testEdicaoEmpresa(){
        $empresa = new Empresa();

        $empresa->nome = 'Flores Lda.';
        $empresa->rua = 'Rua da Senhora da Esperança';
        $empresa->localidade = 'Leiria';
        $empresa->codigoPostal = '2415-542';
        $empresa->NIF = '156854975';
        $empresa->save();

        $this->assertNotNull(Empresa::findOne(['id' => $empresa->id]));

        $empresa->nome = "Leiria";
        $empresa->save();

        $this->assertEquals(Empresa::findOne(['id' => $empresa->id])->nome, $empresa->nome);

    }
}
