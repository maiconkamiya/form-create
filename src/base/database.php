<?php
/**
 * Created by PhpStorm.
 * User: Maicon
 * Date: 16/02/2018
 * Time: 17:26
 */

namespace criativa\base;

use criativa\lib\Model;

class database extends Model{
    public $build = 1;
    public $description = "";
    public $important = false;
    public $optional = false;
    protected $cmd;

    public function dbExecute(){
        $html = "";
        $t = time();
        $i = 0;
        $r = null;
        if (is_array($this->cmd)){
            foreach ($this->cmd as $cmds){


                if (strtoupper($cmds[1]) == 'ADD'){
                    if (!$this->_checkColumn($cmds[0],$cmds[2])){
                        $r = $this->Execute($cmds[3]);
                    }
                } elseif (strtoupper($cmds[1]) == 'CREATE'){
                    $r = $this->Execute($cmds[3]);
                } elseif (strtoupper($cmds[1]) == 'CHANGE'){
                    if ($this->_checkColumn($cmds[0],$cmds[2])) {
                        $r = $this->Execute($cmds[3]);
                    }
                } elseif (strtoupper($cmds[1]) == 'INSERT'){
                    if (empty($cmds[2]) || !$this->_checkRow($cmds[0],$cmds[2])){
                        $r = $this->Execute($cmds[3]);
                    }
                } elseif (strtoupper($cmds[1]) == 'UPDATE'){
                    if ($this->_checkRow($cmds[0],$cmds[2])){
                        $r = $this->Execute($cmds[3]);
                    }
                } elseif (strtoupper($cmds[1]) == 'TRUNCATE'){
                    $r = $this->Execute($cmds[3]);
                } elseif (strtoupper($cmds[1]) == 'IMPORTE'){
                    $this->importCSV($cmds[2],$cmds[3],$cmds[0],(isset($cmds[4]) ? $cmds[4] : array()),(isset($cmds[5]) ? $cmds[5] : ';'), (isset($cmds[6]) ? $cmds[6] : false));
                } elseif (strtoupper($cmds[1]) == 'READSQL'){
                    $this->readSQL($cmds[2], isset($cmds[3]) ? $cmds[3] : array());
                    $r = null;
                }

                if (!is_null($r)){
                    $html .= "<tr>";
                    $html .= "<td>" . ($r['sucess'] || is_null($r) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-exclamation-triangle text-danger"></i>') . "</td>";
                    $html .= "<td>$cmds[0]</td>";
                    $html .= "<td>$cmds[1]</td>";
                    $html .= "<td>";
                    if(isset($r['feedback']) && !empty($r['feedback'])){
                        $html .= $r['feedback'] . '<br>';
                        $html .= $r['sql'];
                    }
                    $html .= "</td>";
                    $html .= "</tr>";
                }

                $i++;
            }

            /*Versão*/
            if ($this->_checkRow('versao',array('tabela'=>get_class($this)))){
                $this->Execute("update `versao` SET build = ".$this->build.", descricao = '".$this->description."', dtupdate = NOW() WHERE tabela = '".get_class($this)."';");
            } else {
                $this->Execute("insert into `versao` (tabela,descricao,build, dtupdate) value ('".get_class($this)."', '".$this->description."', '".$this->build."', NOW());");
            }
        }

        return $html;
    }

    public function readSQL($file, Array $check = null){

        $html = "";

        if (!file_exists($file)){
            return "Arquivo {$file} não existe!";
        }
        $sql = "";
        $t = time();
        $source_file = fopen( $file, "r" ) or die("Não foi possivel abrir o arquivo $file");

        while (($line = fgets($source_file)) !== false) {
            $line = str_replace(array("\n","\r","\t"), " ", $line);
            $sql .= $line;
        }

        $r = $this->Execute($sql);

        $html .= "<tr>";
        $html .= "<td>" . ($r['sucess'] || is_null($r) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-exclamation-triangle text-danger"></i>') . "</td>";
        $html .= "<td>$file</td>";
        $html .= "<td></td>";
        $html .= "<td>";
        if(isset($r['feedback']) && !empty($r['feedback'])){
            $html .= $r['feedback'] . '<br>';
            $html .= $r['sql'];
        }
        $html .= "</td>";
        $html .= "</tr>";

        if (count($check) >0){
            foreach ($check as $i=>$v){
                $r = null;
                switch ($v[0]){
                    case 'ROTINA':
                        $r = $this->existsRotina($v[1]);
                        break;
                    case 'TRIGGER':
                        $r = $this->existsTrigger($v[1]);
                        break;
                }

                if (!is_null($r)){
                    $html .= "<tr>";
                    $html .= "<td>" . ($r ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-exclamation-triangle text-danger"></i>') . "</td>";
                    $html .= "<td>Trigger/Rotina {$v[1]}</td>";
                    $html .= "<td>Verificação</td>";
                    $html .= "<td>".($r ? 'existe' : $v[1] . ' não existe')."</td>";
                    $html .= "</tr>";
                }
            }
        }

        return $html;
    }

    private function _checkColumn($table, $column){
        $q = $this->Select("SHOW COLUMNS FROM `{$table}` LIKE '$column'");
        return count($q) > 0 ? true : false;
    }

    private function _checkRow($table, Array $conditions){
        $sql = "SELECT * FROM {$table} ";

        $nc = 0;
        foreach ($conditions as $i => $v){
            if ($nc <> 0){$sql .= " AND ";}else{$sql .= " WHERE ";}
            $sql .= " {$i} = '{$v}' ";
            $nc++;
        }
        $q = $this->Select($sql);
        return count($q) > 0 ? true : false;
    }

    public function importCSV($file, $columns, $table, $condition = "", $glu = ";", $seo = false){

        if (!file_exists($file))
            die("Arquivo {$file} não localizado!");

        $data = file($file);

        foreach ($data as $line_num => $line)
        {
            $ex = explode($glu, $line);

            foreach ($ex as $i => $v){

                if ($seo)
                    $ex[$i] = _seoURL($ex[$i], ' ');

                if (preg_match('/[0-9]{2}[-|\/]{1}[0-9]{2}[-|\/]{1}[0-9]{4}/', $ex[$i]))
                    $ex[$i] = $this->convertData($ex[$i]);

                if ($ex[$i] == "null")
                    $ex[$i] = null;
            }


            if (empty($condition) || !$this->_checkRow($table,$condition)){
                $sql = "INSERT INTO {$table} (".implode(",",array_values($columns)).") VALUES (\"".implode('","',array_values($ex))."\")";

                $this->Execute($sql);
            }
        }
    }

    private function convertData($data)
    {
        if (!strpos($data,'/')){
            return $data;
        }
        $d = explode('/', $data);
        $data = $d[2] . '-' . $d[1] . '-' . $d[0];
        return $data;
    }

}