<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 09/10/2018
 * Time: 21:17
 */

namespace criativa\base\tabela;

use criativa\base\database;

class dicionario extends database {
    public function __construct(){
        parent::__construct();

        $this->description = "Tabela de Dicionario";

        $tab_name = self::prefix . "_dicionario";

        $this->cmd[] = array("{$tab_name}",'create','',"CREATE TABLE IF NOT EXISTS `{$tab_name}` (
                              `rowid` int NOT NULL AUTO_INCREMENT,
                              `codrotina` int NOT NULL,
                              `tabela` varchar(45) NOT NULL COMMENT 'Tabela principal',
                              `coluna` varchar(45) NOT NULL COMMENT 'Columna da tabela principal',
                              `tipo` varchar(15) NOT NULL COMMENT 'Tipo de valor',
                              `sqlConsulta` text NOT NULL COMMENT 'SQL de Consulta',
                              `sqlLista` text NOT NULL COMMENT 'SQL de Lista de Pesquisa',
                              `sqlValidacao` text NOT NULL COMMENT 'SQL de Validação do campo',
                              `flagFiltroPesquisa` char(1) NOT NULL DEFAULT 'N' COMMENT 'Flag Visualizar filtro de Pesquisa',
                              `flagResultadoPresquisa` char(1) NOT NULL DEFAULT 'S' COMMENT 'Flag Visualizar resultado de Pesquisa',
                              `flagFormulario` char(1) NOT NULL DEFAULT 'S' COMMENT 'Flag Visualizar formulário',
                              `flagObrigatorio` char(1) NOT NULL DEFAULT 'N' COMMENT 'Flag Preenchimento obrigatório',
                              `nome` varchar(45) NOT NULL COMMENT 'Nome do campo',
                              `descricao` text NOT NULL COMMENT 'Descrição do campo',
                              `grupo` varchar(45) NOT NULL COMMENT 'Grupo de informação',
                              PRIMARY KEY (`rowid`)
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

        $this->cmd[] = array($tab_name,'add','flagBloqueado',"ALTER TABLE {$tab_name} ADD `flagBloqueado` char(1) NOT NULL DEFAULT 'N' COMMENT 'Flag Bloqueado para Preenchimento'");
        $this->cmd[] = array($tab_name,'add','flagEditavel',"ALTER TABLE {$tab_name} ADD `flagEditavel` char(1) NOT NULL DEFAULT 'S' COMMENT 'Flag Editavel'");
        $this->cmd[] = array($tab_name,'add','flagBotaoForm',"ALTER TABLE {$tab_name} ADD `flagBotaoForm` char(1) NOT NULL DEFAULT 'N' COMMENT 'Flag Input com Botao'");
        $this->cmd[] = array($tab_name,'add','flagConsultaForm',"ALTER TABLE {$tab_name} ADD `flagConsultaForm` char(1) NOT NULL DEFAULT 'N' COMMENT 'Flag Input com Consulta'");
        $this->cmd[] = array($tab_name,'add','ordem',"ALTER TABLE {$tab_name} ADD `ordem` int NOT NULL DEFAULT 999 COMMENT 'Ordem de visualização'");
        $this->cmd[] = array($tab_name,'add','btnFuncao',"ALTER TABLE {$tab_name} ADD `btnFuncao` text NOT NULL COMMENT 'Script de Função do Botão'");
        $this->cmd[] = array($tab_name,'add','item',"ALTER TABLE {$tab_name} ADD `item` text NOT NULL COMMENT 'Item'");
        $this->cmd[] = array($tab_name,'add','valorPadrao',"ALTER TABLE {$tab_name} ADD `valorPadrao` text NOT NULL COMMENT 'Valor Padrao'");
        $this->cmd[] = array($tab_name,'add','classIndex',"ALTER TABLE {$tab_name} ADD `classIndex` text NOT NULL COMMENT 'Class Index - Load via Script'");
        $this->cmd[] = array($tab_name,'add','flagChavePrimaria',"ALTER TABLE {$tab_name} ADD `flagChavePrimaria` char(1) NOT NULL DEFAULT 'N' COMMENT 'Flag Campo é Chave Primaria'");

        $this->cmd[] = array('','READSQL','./src/base/procedimento/criar_dicionario_de_tabela.sql', array(array('ROTINA','criarDicionarioDeTabela')));

        //versão
        $this->build = 1;
    }
}
