<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 27/09/2021
 * Time: 15:04
 */

namespace criativa\controller\painel;

use criativa\api\versao\ApiVersao;
use criativa\lib\Controller;

class versaoController extends Controller {

    public function __construct(){
        parent::__construct();

        $this->layout = null;
    }

    public function index(){


        $this->view();
    }

    public function getlist(){
        $api = new ApiVersao();
        echo json_encode($api->listTable());
    }

    public function check(){
        $pendencia = array();

        $api = new ApiVersao();
        foreach ($api->listTable() as $i=>$v){
            if ($v->current <> $v->new){
                $pendencia[] = $v;
            }
        }

        echo json_encode($pendencia);
    }

    public function atualizar(){
        $tabela = $this->getParams(0);

        $class = "\\criativa\\base\\tabela\\{$tabela}";

        $exc = new $class();
        echo $exc->dbExecute();
    }
}