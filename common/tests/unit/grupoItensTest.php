<?php


namespace common\tests\Unit;

use common\models\Grupoitens;
use common\tests\UnitTester;

class grupoItensTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests

    //Campo Nome
    public function testCampoNomeAdd()
    {
        $testGrupoItens = new Grupoitens();

        $testGrupoItens->nome = "ASUS";
        $this->assertTrue($testGrupoItens->validate(['nome']));
    }

    public function testCampoNomeNull()
    {
        $testGrupoItens = new Grupoitens();

        $testGrupoItens->nome = null;
        $this->assertFalse($testGrupoItens->validate(['nome']));
    }

    public function testCampoNomeEmpty()
    {
        $testGrupoItens = new Grupoitens();

        $testGrupoItens->nome = "";
        $this->assertFalse($testGrupoItens->validate(['nome']));
    }

    public function testCampoNomeMax()
    {
        $testGrupoItens = new Grupoitens();

        $testGrupoItens->nome = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                           Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown 
                           printer took a galley of type and scrambled it to make a type specimen book.";
        $this->assertFalse($testGrupoItens->validate(['nome']));
    }

    //Campo Notas
    public function testCampoNotasAdd()
    {
        $testGrupoItens = new Grupoitens();

        $testGrupoItens->notas = "Computadores da marca ASUS";
        $this->assertTrue($testGrupoItens->validate(['notas']));
    }

    public function testCampoNotasNull()
    {
        $testGrupoItens = new Grupoitens();

        $testGrupoItens->notas = null;
        $this->assertTrue($testGrupoItens->validate(['notas']));
    }

    public function testCampoNotasEmpty()
    {
        $testGrupoItens = new Grupoitens();

        $testGrupoItens->notas = "";
        $this->assertTrue($testGrupoItens->validate(['notas']));
    }

    /**
     * Validação do Registo
     **/
    public function testRegistoGrupoItens(){
        $grupoItens = new Grupoitens();

        $grupoItens->nome = 'Telemóveis - Laboratório A';
        $grupoItens->notas = null;
        $grupoItens->save();

        $this->assertNotNull(Grupoitens::findOne(['id' => $grupoItens->id]));
    }

    /**
     * Validação da Edição
     **/
    public function testEdicaoGrupoItens(){
        $grupoItens = new Grupoitens();

        $grupoItens->nome = 'Telemóveis - Laboratório A';
        $grupoItens->notas = null;
        $grupoItens->save();

        $this->assertNotNull(Grupoitens::findOne(['id' => $grupoItens->id]));

        $grupoItens->nome = "Leiria";
        $grupoItens->save();

        $this->assertEquals(Grupoitens::findOne(['id' => $grupoItens->id])->nome, $grupoItens->nome);

    }

    /**
     * Validação de Eliminação
     **/
    public function testEliminacaoGrupoItens(){
        $grupoItens = new Grupoitens();

        $grupoItens->nome = 'Telemóveis - Laboratório A';
        $grupoItens->notas = null;
        $grupoItens->save();

        $this->assertNotNull(Grupoitens::findOne(['id' => $grupoItens->id]));

        $grupoItens->status = Grupoitens::STATUS_DELETED;
        $grupoItens->save();

        $this->assertEquals(Grupoitens::STATUS_DELETED, Grupoitens::findOne([$grupoItens->id])->status);
    }
}
