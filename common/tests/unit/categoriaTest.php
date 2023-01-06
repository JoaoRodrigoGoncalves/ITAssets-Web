<?php


namespace common\tests\Unit;

use common\models\Categoria;
use common\tests\UnitTester;

class categoriaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests

    //Campo Nome
    public function testCampoNomeAdd()
    {
        $testCategoria = new Categoria();

        $testCategoria->nome = "Computadores";
        $this->assertTrue($testCategoria->validate(['nome']));
    }

    public function testCampoNomeEmpty()
    {
        $testCategoria = new Categoria();

        $testCategoria->nome = "";
        $this->assertFalse($testCategoria->validate(['nome']));
    }

    public function testCampoNomeNull()
    {
        $testCategoria = new Categoria();

        $testCategoria->nome = null;
        $this->assertFalse($testCategoria->validate(['nome']));
    }

    public function testCampoNomeMax()
    {
        $testCategoria = new Categoria();

        $testCategoria->nome = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer
                                took a galley of type and scrambled it to make a type specimen book.";
        $this->assertFalse($testCategoria->validate(['nome']));
    }

    /**
     * Validação do Registo
     **/
    public function testRegistoCategoria(){
        $categoria = new Categoria();

        $categoria->nome = 'Computadores';
        $categoria->save();

        $this->assertNotNull(Categoria::findOne(['id' => $categoria->id]));
    }

    /**
     * Validação da Edição
     **/
    public function testEdicaoCategoria(){
        $categoria = new Categoria();

        $categoria->nome = 'Computadores';
        $categoria->save();

        $this->assertNotNull(Categoria::findOne(['id' => $categoria->id]));

        $categoria->nome = "Telemóveis";
        $categoria->save();

        $this->assertEquals(Categoria::findOne(['id' => $categoria->id])->nome, $categoria->nome);

    }

    /**
     * Validação de Eliminação
     **/
    public function testEliminacaoCategoria(){
        $categoria = new Categoria();

        $categoria->nome = 'Computadores';
        $categoria->save();

        $this->assertNotNull(Categoria::findOne(['id' => $categoria->id]));

        $categoria->status = Categoria::STATUS_DELETED;
        $categoria->save();

        $this->assertEquals(Categoria::STATUS_DELETED, Categoria::findOne([$categoria->id])->status);
    }
}
