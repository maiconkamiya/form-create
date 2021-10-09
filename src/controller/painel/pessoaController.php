<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 27/09/2021
 * Time: 15:04
 */

namespace criativa\controller\painel;

use criativa\api\pessoa\ApiPessoa;
use criativa\lib\Controller;
use criativa\object\pessoa\Pessoa;

class pessoaController extends Controller {

    private $_rotina = "202";
    private $_tabela = "pessoa";
    private $_chavePrimaria = "codpessoa";

    public function __construct(){
        parent::__construct();

        $this->layout = null;
    }

    public function index(){
        $this->dados['rotina'] = $this->_rotina;
        $this->dados['tabela'] = $this->_tabela;
        $this->dados['chavePrimaria'] = $this->_chavePrimaria;
        $this->dados['uri']['get'] = "pessoa/get";
        $this->dados['uri']['getlist'] = "pessoa/getlist";
        $this->dados['uri']['save'] = "pessoa/save";
        $this->view();
    }

    public function get(){
        $api = new ApiPessoa();
        echo json_encode($api->get(new Pessoa('POST')));
    }

    public function getlist(){
        $api = new ApiPessoa();
        echo json_encode($api->getlist(new Pessoa('POST')));
    }

    public function save(){
        $api = new ApiPessoa();
        echo json_encode($api->save(new Pessoa('POST')));
    }
}