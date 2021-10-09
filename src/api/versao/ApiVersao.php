<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 16/01/2021
 * Time: 11:14
 */

namespace criativa\api\versao;

use criativa\base\tabela\versao;
use criativa\lib\Model;

class ApiVersao extends Model {

    public function __construct(){
        parent::__construct();

        if (!$this->existsTable('versao')){
            $table = new versao();
            $table->dbExecute();
        }
    }

    public function listTable(){
        $a = "./src/base/tabela/";

        $list = array();
        if (is_dir($a)) {
            if ($dh = opendir($a)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file!= '.' && $file != '..'){
                        $class = '\\criativa\\base\\tabela\\' . str_replace('.php','',$file);
                        //require_once "{$a}{$file}";
                        $exc = new $class();

                        $temp = new \stdClass();
                        $temp->nome = str_replace('.php','',$file);
                        $temp->tabela = get_class($exc);
                        $temp->current = $this->get($temp->tabela);
                        $temp->new = $exc->build;
                        $temp->description = $exc->description;
                        $temp->important = $exc->important;
                        $temp->optional = $exc->optional;
                        $temp->status = ($temp->current == $temp->new);

                        $list[] = $temp;
                    }
                }
                closedir($dh);
            }
        }

        return $list;
    }

    public function get($table){
        $query = $this->First($this->Select("SELECT build FROM versao WHERE tabela = '{$table}'"));
        return isset($query->build) ? $query->build : '*';
    }
}