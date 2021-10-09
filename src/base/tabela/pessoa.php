<?php
/**
 * Created by PhpStorm.
 * User: Maicon
 * Date: 19/02/2018
 * Time: 16:49
 */

namespace criativa\base\tabela;

use criativa\base\database;

class pessoa extends database {
    public function __construct(){
        parent::__construct();

        $this->description = "Tabela de Pessoa";

        $tab_name = self::prefix . "_pessoa";

        $this->cmd[] = array("{$tab_name}",'create','',"CREATE TABLE IF NOT EXISTS `{$tab_name}` (
                              `codpessoa` int NOT NULL AUTO_INCREMENT,
                              `tipofj` char(1) NOT NULL DEFAULT 'F' COMMENT 'Tipo Pessoa Física ou Juridica',
                              `razao` text NOT NULL COMMENT 'Nome/Razão Social',
                              `fantasia` text NOT NULL COMMENT 'Nome Fantasia',
                              `cpfcnpj` varchar(14) NOT NULL COMMENT 'CPF/CNPJ',
                              `rg` varchar(14) NOT NULL COMMENT 'RG',
                              `ie` varchar(14) NOT NULL COMMENT 'Inscrição Estadual',
                              `endereco` text NOT NULL COMMENT 'Endereço',
                              `numero` text NOT NULL COMMENT 'Numero',
                              `bairro` text NOT NULL COMMENT 'Bairro',
                              `cep` varchar(8) NOT NULL COMMENT 'Cep',
                              `ibge` varchar(7) NOT NULL COMMENT 'Código IBGE',
                              `municipio` text NOT NULL COMMENT 'Município',
                              `uf` char(2) NOT NULL COMMENT 'UF do estado',
                              `complemento` text NOT NULL COMMENT 'Complemento de endereço',
                              `telefone` varchar(14) NOT NULL COMMENT 'Telefone',
                              `email` text NOT NULL COMMENT 'E-mail',
                              `status` char(1) NOT NULL DEFAULT 'A' COMMENT 'Cadastro Ativo',
                              `statusfornecedor` char(1) NOT NULL DEFAULT 'I' COMMENT 'Status Fornecedor',
                              `statustransportador` char(1) NOT NULL DEFAULT 'I' COMMENT 'Status Transportador',
                              `contribuinte` int NOT NULL DEFAULT 9 COMMENT 'Cadastro de Contribuinte',
                              `consumidorfinal` int NOT NULL DEFAULT 0 COMMENT 'Cadastro de Consumidor final',
                              PRIMARY KEY (`codpessoa`)
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

        //versão
        $this->build = 1;
    }
}