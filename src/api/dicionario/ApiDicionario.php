<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 28/09/2021
 * Time: 10:17
 */

namespace criativa\api\dicionario;

use criativa\lib\Model;
use criativa\object\dicionario\Dicionario;

class ApiDicionario extends Model {

    private $prefix = self::prefix;

    public function getlist(Dicionario $obj){
        $sql = " SELECT d.* FROM {$this->prefix}_dicionario d WHERE 1=1 ";

        foreach ($obj as $i => $v){
            if (!empty($v)){
                if ($v == 'isNull'){
                    $sql .= " AND d.{$i} IS NULL ";
                } elseif ($v == 'isNotNull'){
                    $sql .= " AND d.{$i} IS NOT NULL ";
                } elseif ($v == 'isEmpty'){
                    $sql .= " AND d.{$i} = '' ";
                } elseif ($v == 'isNotEmpty'){
                    $sql .= " AND d.{$i} != '' ";
                } elseif (is_array($v)){
                    $sql .= " AND d.{$i} BETWEEN '{$v[0]}' AND '{$v[1]}' ";
                } elseif (strpbrk($v, ',')){
                    $sql .= " AND d.{$i} IN({$v}) ";
                } elseif (strpbrk($v, '%')){
                    $sql .= " AND d.{$i} LIKE '{$v}%' ";
                } else {
                    $sql .= " AND d.{$i} = '{$v}'";
                }
            }
        }

        $sql .= " ORDER by d.ordem, d.grupo ";

        return $this->Select($sql);
    }

    public function save(Dicionario $obj){
        if (empty($obj->rowid)){
            return $this->Insert($obj, self::prefix . '_dicionario');
        } else {
            return $this->Update($obj, array('rowid'=>$obj->rowid), self::prefix . '_dicionario');
        }
    }

    public function criar(Dicionario $obj){
        if (empty($obj->tabela)){
            return;
        }

        if (empty($obj->codrotina)){
            return;
        }

        $banco = self::srvMydbname;
        $prefixo = self::prefix;
        $this->Execute("CALL criarDicionarioDeTabela('{$banco}', '{$prefixo}', '{$obj->tabela}', '{$obj->codrotina}')");
    }
}