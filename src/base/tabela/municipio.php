<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 09/10/2018
 * Time: 21:17
 */
namespace criativa\base\tabela;

use criativa\base\database;

class municipio extends database {
    public function __construct(){
        parent::__construct();

        $this->description = "Tabela de Municipio";

        $tab_name = self::prefix . "_municipio";

        $this->cmd[] = array("{$tab_name}",'create','',"CREATE TABLE IF NOT EXISTS `{$tab_name}` (
                              `id` int(11) NOT NULL AUTO_INCREMENT,
                              `idestado` int(11) NOT NULL,
                              `municipio` text NOT NULL,
                              `ibge` varchar(7) NOT NULL,
                              PRIMARY KEY(`id`)
                          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

        $this->cmd[] = array($tab_name,'importe',"./src/base/arquivo/tabela_cidade.csv",array('id','idestado','municipio','ibge'));

        //versão
        $this->build = 1;
    }
}
