<?php

use yii\db\Migration;

/**
 * Class m221025_122800_init_rbac
 */
class m221025_122800_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221025_122800_init_rbac cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

        $auth = Yii::$app->authManager;

        $auth->removeAll();

        $auth = Yii::$app->authManager;

        // Cria a permissão CriarAlocacaoItem - Criar pedido de alocação de item
        $CriarAlocacaoItem = $auth->createPermission("CriarAlocacaoItem");
        $CriarAlocacaoItem->description = "Criar pedido de alocação de item";
        $auth->add($CriarAlocacaoItem);

        // Cria a permissão CriarReparacaoItem - Criar pedido de reparação de item
        $CriarReparacaoItem = $auth->createPermission("CriarReparacaoItem");
        $CriarReparacaoItem->description = "Criar pedido de reparação de item";
        $auth->add($CriarReparacaoItem);

        // Cria a permissão ConsultarPedidoAlocacaoProprio - Consultar um pedido de alocação criado pelo próprio utilizador
        $ConsultarPedidoAlocacaoProprio = $auth->createPermission("ConsultarPedidoAlocacaoProprio");
        $ConsultarPedidoAlocacaoProprio->description = "Consultar um pedido de alocação criado pelo próprio utilizador";
        $auth->add($ConsultarPedidoAlocacaoProprio);

        // Cria a permissão ConsultarPedidoReparacaoProprio - Consultar um pedido de reparação criado pelo próprio utilizador
        $ConsultarPedidoReparacaoProprio = $auth->createPermission("ConsultarPedidoReparacaoProprio");
        $ConsultarPedidoReparacaoProprio->description = "Consultar um pedido de reparação criado pelo próprio utilizador";
        $auth->add($ConsultarPedidoReparacaoProprio);

        // Cria a permissão EditarAlocacaoItem - Editar um pedido de alocação de um item
        $EditarAlocacaoItem = $auth->createPermission("EditarAlocacaoItem");
        $EditarAlocacaoItem->description = "Editar um pedido de alocação de um item";
        $auth->add($EditarAlocacaoItem);

        // Cria a permissão EditarReapacaoItem - Editar um pedido de reparação de um item
        $EditarReapacaoItem = $auth->createPermission("EditarReapacaoItem");
        $EditarReapacaoItem->description = "Editar um pedido de reparação de um item";
        $auth->add($EditarReapacaoItem);

        // Cria a permissão CancelarAlocacaoItem - Cancelar pedido de alocação de item
        $CancelarAlocacaoItem = $auth->createPermission("CancelarAlocacaoItem");
        $CancelarAlocacaoItem->description = "Cancelar pedido de alocação de item";
        $auth->add($CancelarAlocacaoItem);

        // Cria a permissão CancelarReparacaoItem - Cancelar pedido de reparação de item
        $CancelarReparacaoItem = $auth->createPermission("CancelarReparacaoItem");
        $CancelarReparacaoItem->description = "Cancelar pedido de reparação de item";
        $auth->add($CancelarReparacaoItem);

        // Cria a permissão ConsultarListaItems - Consultar a lista de items
        $ConsultarListaItems = $auth->createPermission("ConsultarListaItems");
        $ConsultarListaItems->description = "Consultar a lista de items";
        $auth->add($ConsultarListaItems);

        // Cria a permissão ConsultarDetalhesItem - Constultar detalhes de um item
        $ConsultarDetalhesItem = $auth->createPermission("ConsultarDetalhesItem");
        $ConsultarDetalhesItem->description = "Constultar detalhes de um item";
        $auth->add($ConsultarDetalhesItem);

        // Cria a permissão ConsultarPropriaConta - Consultar dados da conta sua própria conta de utilizador
        $ConsultarPropriaConta = $auth->createPermission("ConsultarPropriaConta");
        $ConsultarPropriaConta->description = "Consultar dados da conta sua própria conta de utilizador";
        $auth->add($ConsultarPropriaConta);

        // Cria a permissão EditarPropriaConta - Editar dados da sua própria conta de utilizador
        $EditarPropriaConta = $auth->createPermission("EditarPropriaConta");
        $EditarPropriaConta->description = "Editar dados da sua própria conta de utilizador";
        $auth->add($EditarPropriaConta);

        // Cria a permissão EditarEstadoPedidoAlocacaoItem - Editar o estado de um pedido de alocação de item
        $EditarEstadoPedidoAlocacaoItem = $auth->createPermission("EditarEstadoPedidoAlocacaoItem");
        $EditarEstadoPedidoAlocacaoItem->description = "Editar o estado de um pedido de alocação de item";
        $auth->add($EditarEstadoPedidoAlocacaoItem);

        // Cria a permissão CriarItens - Adicionar itens à aplicação
        $CriarItens = $auth->createPermission("CriarItens");
        $CriarItens->description = "Adicionar itens à aplicação";
        $auth->add($CriarItens);

        // Cria a permissão EditarItem - Editar detalhes de um item
        $EditarItem = $auth->createPermission("EditarItem");
        $EditarItem->description = "Editar detalhes de um item";
        $auth->add($EditarItem);

        // Cria a permissão ConsultarItensAssociadosUtilizador - Consultar que itens estão associados a um utilizador
        $ConsultarItensAssociadosUtilizador = $auth->createPermission("ConsultarItensAssociadosUtilizador");
        $ConsultarItensAssociadosUtilizador->description = "Consultar que itens estão associados a um utilizador";
        $auth->add($ConsultarItensAssociadosUtilizador);

        // Cria a permissão ConsultarPedidoAlocacao - Consultar um pedido de alocação
        $ConsultarPedidoAlocacao = $auth->createPermission("ConsultarPedidoAlocacao");
        $ConsultarPedidoAlocacao->description = "Consultar um pedido de alocação";
        $auth->add($ConsultarPedidoAlocacao);

        // Cria a permissão ConsultarPedidoReparacao - Consultar um pedido de reparação
        $ConsultarPedidoReparacao = $auth->createPermission("ConsultarPedidoReparacao");
        $ConsultarPedidoReparacao->description = "Consultar um pedido de reparação";
        $auth->add($ConsultarPedidoReparacao);

        // Cria a permissão ConsultarHistoricoReparacoesItem - Consultar o histórico de reparações de um item
        $ConsultarHistoricoReparacoesItem = $auth->createPermission("ConsultarHistoricoReparacoesItem");
        $ConsultarHistoricoReparacoesItem->description = "Consultar o histórico de reparações de um item";
        $auth->add($ConsultarHistoricoReparacoesItem);

        // Cria a permissão ConsultarValorReparacaoItem - Consultar o valor da reparação de um item
        $ConsultarValorReparacaoItem = $auth->createPermission("ConsultarValorReparacaoItem");
        $ConsultarValorReparacaoItem->description = "Consultar o valor da reparação de um item";
        $auth->add($ConsultarValorReparacaoItem);

        // Cria a permissão EliminarItem - Eliminar um item
        $EliminarItem = $auth->createPermission("EliminarItem");
        $EliminarItem->description = "Eliminar um item";
        $auth->add($EliminarItem);

        // Cria a permissão VerDetalhesUtilizador - Ver detalhes de um utilizador
        $VerDetalhesUtilizador = $auth->createPermission("VerDetalhesUtilizador");
        $VerDetalhesUtilizador->description = "Ver detalhes de um utilizador";
        $auth->add($VerDetalhesUtilizador);

        // Cria a permissão RegistarUtilizador - Registar novos utilizadores
        $RegistarUtilizador = $auth->createPermission("RegistarUtilizador");
        $RegistarUtilizador->description = "Registar novos utilizadores";
        $auth->add($RegistarUtilizador);

        // Cria a permissão EditarUtilizador - Editar um utilizador
        $EditarUtilizador = $auth->createPermission("EditarUtilizador");
        $EditarUtilizador->description = "Editar um utilizador";
        $auth->add($EditarUtilizador);

        // Cria a permissão EliminarUtilizador - Eliminar um utilizador
        $EliminarUtilizador = $auth->createPermission("EliminarUtilizador");
        $EliminarUtilizador->description = "Eliminar um utilizador";
        $auth->add($EliminarUtilizador);

        // Cria o utilizador "Funcionario"
        $user = $auth->createRole("funcionario");
        $auth->add($user);
        $auth->addChild($user, $CriarAlocacaoItem);
        $auth->addChild($user, $CriarReparacaoItem);
        $auth->addChild($user, $ConsultarPedidoAlocacaoProprio);
        $auth->addChild($user, $ConsultarPedidoReparacaoProprio);
        $auth->addChild($user, $EditarAlocacaoItem);
        $auth->addChild($user, $EditarReapacaoItem);
        $auth->addChild($user, $CancelarAlocacaoItem);
        $auth->addChild($user, $CancelarReparacaoItem);
        $auth->addChild($user, $ConsultarListaItems);
        $auth->addChild($user, $ConsultarDetalhesItem);
        $auth->addChild($user, $ConsultarPropriaConta);
        $auth->addChild($user, $EditarPropriaConta);

        // Cria o utilizador "Operador Logistica"
        $logistica = $auth->createRole("operadorLogistica");
        $auth->add($logistica);
        $auth->addChild($logistica, $user);
        $auth->addChild($logistica, $EditarEstadoPedidoAlocacaoItem);
        $auth->addChild($logistica, $CriarItens);
        $auth->addChild($logistica, $EditarItem);
        $auth->addChild($logistica, $ConsultarItensAssociadosUtilizador);
        $auth->addChild($logistica, $ConsultarPedidoAlocacao);
        $auth->addChild($logistica, $ConsultarPedidoReparacao);
        $auth->addChild($logistica, $ConsultarHistoricoReparacoesItem);
        $auth->addChild($logistica, $ConsultarValorReparacaoItem);
        $auth->addChild($logistica, $EliminarItem);
        $auth->addChild($logistica, $VerDetalhesUtilizador);

        // Cria o utilizador "Administrador"
        $admin = $auth->createRole("administrador");
        $auth->add($admin);
        $auth->addChild($admin, $logistica);
        $auth->addChild($admin, $RegistarUtilizador);
        $auth->addChild($admin, $EditarUtilizador);
        $auth->addChild($admin, $EliminarUtilizador);


    }

    public function down()
    {
        $auth = Yii::$app->authManager;

        // Cria a permissão Criar AlocacaoItem - Criar pedido de alocação de item
        $CriarAlocacaoItem = $auth->createPermission("Criar AlocacaoItem");
        $CriarAlocacaoItem->description = "Criar pedido de alocação de item";
        $auth->add($CriarAlocacaoItem);
        
        // Cria a permissão CriarReparacaoItem - Criar pedido de reparação de item
        $CriarReparacaoItem = $auth->createPermission("CriarReparacaoItem");
        $CriarReparacaoItem->description = "Criar pedido de reparação de item";
        $auth->add($CriarReparacaoItem);
        
        // Cria a permissão ConsultarPedidoAlocacaoProprio - Consultar um pedido de alocação criado pelo próprio utilizador
        $ConsultarPedidoAlocacaoProprio = $auth->createPermission("ConsultarPedidoAlocacaoProprio");
        $ConsultarPedidoAlocacaoProprio->description = "Consultar um pedido de alocação criado pelo próprio utilizador";
        $auth->add($ConsultarPedidoAlocacaoProprio);
        
        // Cria a permissão ConsultarPedidoReparacaoProprio - Consultar um pedido de reparação criado pelo próprio utilizador
        $ConsultarPedidoReparacaoProprio = $auth->createPermission("ConsultarPedidoReparacaoProprio");
        $ConsultarPedidoReparacaoProprio->description = "Consultar um pedido de reparação criado pelo próprio utilizador";
        $auth->add($ConsultarPedidoReparacaoProprio);
        
        // Cria a permissão EditarAlocacaoItem - Editar um pedido de alocação de um item
        $EditarAlocacaoItem = $auth->createPermission("EditarAlocacaoItem");
        $EditarAlocacaoItem->description = "Editar um pedido de alocação de um item";
        $auth->add($EditarAlocacaoItem);
        
        // Cria a permissão EditarReapacaoItem - Editar um pedido de reparação de um item
        $EditarReapacaoItem = $auth->createPermission("EditarReapacaoItem");
        $EditarReapacaoItem->description = "Editar um pedido de reparação de um item";
        $auth->add($EditarReapacaoItem);
        
        // Cria a permissão CancelarAlocacaoItem - Cancelar pedido de alocação de item
        $CancelarAlocacaoItem = $auth->createPermission("CancelarAlocacaoItem");
        $CancelarAlocacaoItem->description = "Cancelar pedido de alocação de item";
        $auth->add($CancelarAlocacaoItem);
        
        // Cria a permissão CancelarReparacaoItem - Cancelar pedido de reparação de item
        $CancelarReparacaoItem = $auth->createPermission("CancelarReparacaoItem");
        $CancelarReparacaoItem->description = "Cancelar pedido de reparação de item";
        $auth->add($CancelarReparacaoItem);
        
        // Cria a permissão ConsultarListaItems - Consultar a lista de items
        $ConsultarListaItems = $auth->createPermission("ConsultarListaItems");
        $ConsultarListaItems->description = "Consultar a lista de items";
        $auth->add($ConsultarListaItems);
        
        // Cria a permissão ConsultarDetalhesItem - Constultar detalhes de um item
        $ConsultarDetalhesItem = $auth->createPermission("ConsultarDetalhesItem");
        $ConsultarDetalhesItem->description = "Constultar detalhes de um item";
        $auth->add($ConsultarDetalhesItem);
        
        // Cria a permissão ConsultarPropriaConta - Consultar dados da conta sua própria conta de utilizador
        $ConsultarPropriaConta = $auth->createPermission("ConsultarPropriaConta");
        $ConsultarPropriaConta->description = "Consultar dados da conta sua própria conta de utilizador";
        $auth->add($ConsultarPropriaConta);
        
        // Cria a permissão EditarPropriaConta - Editar dados da sua própria conta de utilizador
        $EditarPropriaConta = $auth->createPermission("EditarPropriaConta");
        $EditarPropriaConta->description = "Editar dados da sua própria conta de utilizador";
        $auth->add($EditarPropriaConta);
        
        // Cria a permissão EditarEstadoPedidoAlocacaoItem - Editar o estado de um pedido de alocação de item
        $EditarEstadoPedidoAlocacaoItem = $auth->createPermission("EditarEstadoPedidoAlocacaoItem");
        $EditarEstadoPedidoAlocacaoItem->description = "Editar o estado de um pedido de alocação de item";
        $auth->add($EditarEstadoPedidoAlocacaoItem);
        
        // Cria a permissão CriarItens - Adicionar itens à aplicação
        $CriarItens = $auth->createPermission("CriarItens");
        $CriarItens->description = "Adicionar itens à aplicação";
        $auth->add($CriarItens);
        
        // Cria a permissão EditarItem - Editar detalhes de um item
        $EditarItem = $auth->createPermission("EditarItem");
        $EditarItem->description = "Editar detalhes de um item";
        $auth->add($EditarItem);
        
        // Cria a permissão ConsultarItensAssociadosUtilizador - Consultar que itens estão associados a um utilizador
        $ConsultarItensAssociadosUtilizador = $auth->createPermission("ConsultarItensAssociadosUtilizador");
        $ConsultarItensAssociadosUtilizador->description = "Consultar que itens estão associados a um utilizador";
        $auth->add($ConsultarItensAssociadosUtilizador);
        
        // Cria a permissão ConsultarPedidoAlocacao - Consultar um pedido de alocação
        $ConsultarPedidoAlocacao = $auth->createPermission("ConsultarPedidoAlocacao");
        $ConsultarPedidoAlocacao->description = "Consultar um pedido de alocação";
        $auth->add($ConsultarPedidoAlocacao);
        
        // Cria a permissão ConsultarPedidoReparacao - Consultar um pedido de reparação
        $ConsultarPedidoReparacao = $auth->createPermission("ConsultarPedidoReparacao");
        $ConsultarPedidoReparacao->description = "Consultar um pedido de reparação";
        $auth->add($ConsultarPedidoReparacao);
        
        // Cria a permissão ConsultarHistoricoReparacoesItem - Consultar o histórico de reparações de um item
        $ConsultarHistoricoReparacoesItem = $auth->createPermission("ConsultarHistoricoReparacoesItem");
        $ConsultarHistoricoReparacoesItem->description = "Consultar o histórico de reparações de um item";
        $auth->add($ConsultarHistoricoReparacoesItem);
        
        // Cria a permissão ConsultarValorReparacaoItem - Consultar o valor da reparação de um item
        $ConsultarValorReparacaoItem = $auth->createPermission("ConsultarValorReparacaoItem");
        $ConsultarValorReparacaoItem->description = "Consultar o valor da reparação de um item";
        $auth->add($ConsultarValorReparacaoItem);
        
        // Cria a permissão EliminarItem - Eliminar um item
        $EliminarItem = $auth->createPermission("EliminarItem");
        $EliminarItem->description = "Eliminar um item";
        $auth->add($EliminarItem);
        
        // Cria a permissão VerDetalhesUtilizador - Ver detalhes de um utilizador
        $VerDetalhesUtilizador = $auth->createPermission("VerDetalhesUtilizador");
        $VerDetalhesUtilizador->description = "Ver detalhes de um utilizador";
        $auth->add($VerDetalhesUtilizador);
        
        // Cria a permissão RegistarUtilizador - Registar novos utilizadores
        $RegistarUtilizador = $auth->createPermission("RegistarUtilizador");
        $RegistarUtilizador->description = "Registar novos utilizadores";
        $auth->add($RegistarUtilizador);
        
        // Cria a permissão EditarUtilizador - Editar um utilizador
        $EditarUtilizador = $auth->createPermission("EditarUtilizador");
        $EditarUtilizador->description = "Editar um utilizador";
        $auth->add($EditarUtilizador);
        
        // Cria a permissão EliminarUtilizador - Eliminar um utilizador
        $EliminarUtilizador = $auth->createPermission("EliminarUtilizador");
        $EliminarUtilizador->description = "Eliminar um utilizador";
        $auth->add($EliminarUtilizador);
        
        // Cria o utilizador "Utilizador"
        $user = $auth->createRole("utilizador");
        $auth->add($user);
        $auth->addChild($user, $CriarAlocacaoItem);
        $auth->addChild($user, $CriarReparacaoItem);
        $auth->addChild($user, $ConsultarPedidoAlocacaoProprio);
        $auth->addChild($user, $ConsultarPedidoReparacaoProprio);
        $auth->addChild($user, $EditarAlocacaoItem);
        $auth->addChild($user, $EditarReapacaoItem);
        $auth->addChild($user, $CancelarAlocacaoItem);
        $auth->addChild($user, $CancelarReparacaoItem);
        $auth->addChild($user, $ConsultarListaItems);
        $auth->addChild($user, $ConsultarDetalhesItem);
        $auth->addChild($user, $ConsultarPropriaConta);
        $auth->addChild($user, $EditarPropriaConta);
        
        // Cria o utilizador "Utilizador Logistica"
        $logistica = $auth->createRole("utilizadorLogistica");
        $auth->add($logistica);
        $auth->addChild($logistica, $user);
        $auth->addChild($logistica, $EditarEstadoPedidoAlocacaoItem);
        $auth->addChild($logistica, $CriarItens);
        $auth->addChild($logistica, $EditarItem);
        $auth->addChild($logistica, $ConsultarItensAssociadosUtilizador);
        $auth->addChild($logistica, $ConsultarPedidoAlocacao);
        $auth->addChild($logistica, $ConsultarPedidoReparacao);
        $auth->addChild($logistica, $ConsultarHistoricoReparacoesItem);
        $auth->addChild($logistica, $ConsultarValorReparacaoItem);
        $auth->addChild($logistica, $EliminarItem);
        $auth->addChild($logistica, $VerDetalhesUtilizador);
        
        // Cria o utilizador "Administrador"
        $admin = $auth->createRole("administrador");
        $auth->add($admin);
        $auth->addChild($admin, $logistica);
        $auth->addChild($admin, $RegistarUtilizador);
        $auth->addChild($admin, $EditarUtilizador);
        $auth->addChild($admin, $EliminarUtilizador);
    }

}
