<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 07/10/2021
 * Time: 11:13
 */

namespace criativa\api\ibge;

use criativa\lib\Model;
use criativa\object\ibge\Estado;

class ApiEstado extends Model {

    private $prefix = self::prefix;

    public function get(Estado $obj){
        $sql = " SELECT t.* FROM {$this->prefix}_estado t WHERE 1=1 ";

        $sql .= $this->where($obj);

        return $this->First($this->Select($sql));
    }

    public function getlist(Estado $obj){
        $sql = " SELECT t.* FROM {$this->prefix}_estado t WHERE 1=1 ";

        $sql .= $this->where($obj);

        return $this->Select($sql);
    }

}