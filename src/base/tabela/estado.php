<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 09/10/2018
 * Time: 21:17
 */
namespace criativa\base\tabela;

use criativa\base\database;

class estado extends database {
    public function __construct(){
        parent::__construct();

        $this->description = "Tabela de Estado";

        $tab_name = self::prefix . "_estado";

        $this->cmd[] = array("{$tab_name}",'create','',"CREATE TABLE IF NOT EXISTS `{$tab_name}` (
                              `id` int(11) NOT NULL AUTO_INCREMENT,
                              `estado` text NOT NULL,
                              `uf` char(2) NOT NULL,
                              `ibge` char(2) NOT NULL,
                              PRIMARY KEY(`id`)
                          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

        $this->cmd[] = array($tab_name,'importe',"./src/base/arquivo/tabela_estado.csv",array('id','estado','uf','ibge'));

        //versão
        $this->build = 1;
    }
}
