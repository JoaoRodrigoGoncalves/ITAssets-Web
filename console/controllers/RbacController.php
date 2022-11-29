<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionWrite()
    {
        try
        {
            $auth = Yii::$app->authManager;

            $auth->removeAll();

            // Cria a permissão readEmpresa - Ver dados empresa
            $readEmpresa = $auth->createPermission('readEmpresa');
            $readEmpresa->description = "Ver dados empresa";
            $auth->add($readEmpresa);

            // Cria a permissão writeEmpresa - CUD empresa
            $writeEmpresa = $auth->createPermission('writeEmpresa');
            $writeEmpresa->description = "CUD empresa";
            $auth->add($writeEmpresa);

            // Cria a permissão readSite - Ver dados site
            $readSite = $auth->createPermission('readSite');
            $readSite->description = "Ver dados site";
            $auth->add($readSite);

            // Cria a permissão writeSite - CUD site
            $writeSite = $auth->createPermission('writeSite');
            $writeSite->description = "CUD site";
            $auth->add($writeSite);

            // Cria a permissão readCategoria - Ver dados categoria
            $readCategoria = $auth->createPermission('readCategoria');
            $readCategoria->description = "Ver dados categoria";
            $auth->add($readCategoria);

            // Cria a permissão writeCategoria - CUD categoria
            $writeCategoria = $auth->createPermission('writeCategoria');
            $writeCategoria->description = "CUD categoria";
            $auth->add($writeCategoria);

            // Cria a permissão readItem - Ver dados itens
            $readItem = $auth->createPermission('readItem');
            $readItem->description = "Ver dados itens";
            $auth->add($readItem);

            // Cria a permissão writeItem - CUD Item
            $writeItem = $auth->createPermission('writeItem');
            $writeItem->description = "CUD Item";
            $auth->add($writeItem);

            // Cria a permissão readGrupoItens - Ver dados de um grupo de itens
            $readGrupoItens = $auth->createPermission('readGrupoItens');
            $readGrupoItens->description = "Ver dados de um grupo de itens";
            $auth->add($readGrupoItens);

            // Cria a permissão writeGrupoItens - CUD Grupo itens
            $writeGrupoItens = $auth->createPermission('writeGrupoItens');
            $writeGrupoItens->description = "CUD Grupo itens";
            $auth->add($writeGrupoItens);

            // Cria a permissão readUtilizador - Ver dados Utilizadores
            $readUtilizador = $auth->createPermission('readUtilizador');
            $readUtilizador->description = "Ver dados Utilizadores";
            $auth->add($readUtilizador);

            // Cria a permissão writeUtilizador - CUD utilizador
            $writeUtilizador = $auth->createPermission('writeUtilizador');
            $writeUtilizador->description = "CUD utilizador";
            $auth->add($writeUtilizador);

            // Cria a permissão createPedidoAlocacao - Criar um pedido de alocacao
            $createPedidoAlocacao = $auth->createPermission('createPedidoAlocacao');
            $createPedidoAlocacao->description = "Criar um pedido de alocacao";
            $auth->add($createPedidoAlocacao);

            // Cria a permissão editPedidoAlocacao - Editar um pedido de alocacao
            $editPedidoAlocacao = $auth->createPermission('editPedidoAlocacao');
            $editPedidoAlocacao->description = "Editar um pedido de alocacao";
            $auth->add($editPedidoAlocacao);

            // Cria a permissão cancelPedidoAlocacao - Cancelar um pedido de alocacao
            $cancelPedidoAlocacao = $auth->createPermission('cancelPedidoAlocacao');
            $cancelPedidoAlocacao->description = "Cancelar um pedido de alocacao";
            $auth->add($cancelPedidoAlocacao);

            // Cria a permissão readOthersPedidoAlocacao - Ler pedido de alocacao criado por outro utilizador
            $readOthersPedidoAlocacao = $auth->createPermission('readOthersPedidoAlocacao');
            $readOthersPedidoAlocacao->description = "Ler pedido de alocacao criado por outro utilizador";
            $auth->add($readOthersPedidoAlocacao);

            // Cria a permissão changeStatusPedidoAlocacao - Autorizar/Negar um pedido de alocacao
            $changeStatusPedidoAlocacao = $auth->createPermission('changeStatusPedidoAlocacao');
            $changeStatusPedidoAlocacao->description = "Autorizar/Negar um pedido de alocacao";
            $auth->add($changeStatusPedidoAlocacao);

            // Cria a permissão createPedidoReparacao - Criar um pedido de reparacao
            $createPedidoReparacao = $auth->createPermission('createPedidoReparacao');
            $createPedidoReparacao->description = "Criar um pedido de reparacao";
            $auth->add($createPedidoReparacao);

            // Cria a permissão editPedidoReparacao - Editar um pedido de reparacao
            $editPedidoReparacao = $auth->createPermission('editPedidoReparacao');
            $editPedidoReparacao->description = "Editar um pedido de reparacao";
            $auth->add($editPedidoReparacao);

            // Cria a permissão cancelPedidoReparacao - Cancelar um pedido de reparacao
            $cancelPedidoReparacao = $auth->createPermission('cancelPedidoReparacao');
            $cancelPedidoReparacao->description = "Cancelar um pedido de reparacao";
            $auth->add($cancelPedidoReparacao);

            // Cria a permissão readOthersPedidoReparacao - Ler pedido de reparacao criado por outro utilizador
            $readOthersPedidoReparacao = $auth->createPermission('readOthersPedidoReparacao');
            $readOthersPedidoReparacao->description = "Ler pedido de reparacao criado por outro utilizador";
            $auth->add($readOthersPedidoReparacao);

            // Cria a permissão changeStatusPedidoReparacao - Autorizar/Negar um pedido de reparacao
            $changeStatusPedidoReparacao = $auth->createPermission('changeStatusPedidoReparacao');
            $changeStatusPedidoReparacao->description = "Autorizar/Negar um pedido de reparacao";
            $auth->add($changeStatusPedidoReparacao);

            // Cria a permissão addDespesasPedidoReparacao - Adicionar despesas a um pedido de reparacao
            $addDespesasPedidoReparacao = $auth->createPermission('addDespesasPedidoReparacao');
            $addDespesasPedidoReparacao->description = "Adicionar despesas a um pedido de reparacao";
            $auth->add($addDespesasPedidoReparacao);

            // Cria o utilizador "Funcionario"
            $user = $auth->createRole("funcionario");
            $auth->add($user);
            $auth->addChild($user, $readEmpresa);
            $auth->addChild($user, $readSite);
            $auth->addChild($user, $readCategoria);
            $auth->addChild($user, $readItem);
            $auth->addChild($user, $readGrupoItens);
            $auth->addChild($user, $readUtilizador);
            $auth->addChild($user, $createPedidoAlocacao);
            $auth->addChild($user, $editPedidoAlocacao);
            $auth->addChild($user, $cancelPedidoAlocacao);
            $auth->addChild($user, $createPedidoReparacao);
            $auth->addChild($user, $editPedidoReparacao);
            $auth->addChild($user, $cancelPedidoReparacao);

            // Cria o utilizador "Operador Logistica"
            $logistica = $auth->createRole("operadorLogistica");
            $auth->add($logistica);
            $auth->addChild($logistica, $user);
            $auth->addChild($logistica, $writeSite);
            $auth->addChild($logistica, $writeCategoria);
            $auth->addChild($logistica, $writeItem);
            $auth->addChild($logistica, $writeGrupoItens);
            $auth->addChild($logistica, $readOthersPedidoAlocacao);
            $auth->addChild($logistica, $changeStatusPedidoAlocacao);
            $auth->addChild($logistica, $readOthersPedidoReparacao);
            $auth->addChild($logistica, $changeStatusPedidoReparacao);
            $auth->addChild($logistica, $addDespesasPedidoReparacao);

            // Cria o utilizador "Administrador"
            $admin = $auth->createRole("administrador");
            $auth->add($admin);
            $auth->addChild($admin, $logistica);
            $auth->addChild($admin, $writeEmpresa);
            $auth->addChild($admin, $writeUtilizador);
        }
        catch (\Exception $exception)
        {
            print_r($exception->getTrace());
        }
    }

    public function actionClear()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
}