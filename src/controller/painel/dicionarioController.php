<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 27/09/2021
 * Time: 15:04
 */

namespace criativa\controller\painel;

use criativa\api\dicionario\ApiDicionario;
use criativa\lib\Controller;
use criativa\object\dicionario\Dicionario;

class dicionarioController extends Controller {

    private $_rotina = "9999";
    private $_tabela = "dicionario";
    private $_chavePrimaria = "rowid";

    public function __construct(){
        parent::__construct();

        $this->layout = null;
    }

    public function index(){
        $this->dados['rotina'] = $this->_rotina;
        $this->dados['tabela'] = $this->_tabela;
        $this->dados['chavePrimaria'] = $this->_chavePrimaria;
        $this->dados['uri']['get'] = "dicionario/get";
        $this->dados['uri']['getlist'] = "dicionario/getlist";
        $this->dados['uri']['save'] = "dicionario/save";
        $this->view();
    }

    public function form(){
        switch ($this->getParams(0)){
            case 'gerarportabela':
                $this->_formGerarPorTabela();
                break;
            default:
                break;
        }
    }

    private function _formGerarPorTabela(){
        $this->view('form/gerarportabela');
    }

    public function getlist(){
        $api = new ApiDicionario();
        echo json_encode($api->getlist(new Dicionario('POST')));
    }

    public function save(){
        $api = new ApiDicionario();
        echo json_encode($api->save(new Dicionario('POST')));
    }

    public function criar(){
        $api = new ApiDicionario();
        $api->criar(new Dicionario('POST'));
    }
}