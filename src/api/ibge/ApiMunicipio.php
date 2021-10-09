<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 07/10/2021
 * Time: 11:13
 */

namespace criativa\api\ibge;

use criativa\lib\Model;
use criativa\object\ibge\Municipio;

class ApiMunicipio extends Model {

    private $prefix = self::prefix;

    public function get(Municipio $obj){
        $sql = " SELECT t.*, e.estado, e.uf FROM {$this->prefix}_municipio t, {$this->prefix}_estado e WHERE t.idestado = e.id ";

        $sql .= $this->where($obj);

        return $this->First($this->Select($sql));
    }

    public function getlist(Municipio $obj){
        $sql = " SELECT t.*, e.estado, e.uf FROM {$this->prefix}_municipio t, {$this->prefix}_estado e WHERE t.idestado = e.id ";

        $sql .= $this->where($obj);

        return $this->Select($sql);
    }

}