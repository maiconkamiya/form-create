<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 30/09/2021
 * Time: 11:27
 */

namespace criativa\controller\painel;

use criativa\api\ibge\ApiEstado;
use criativa\api\ibge\ApiMunicipio;
use criativa\lib\Controller;
use criativa\object\ibge\Estado;
use criativa\object\ibge\Municipio;

class ibgeController extends Controller {
    private $_rotina = "510";
    private $_tabela = "ibge";

    public function __construct(){
        parent::__construct();

        $this->layout = null;
    }

    public function find(){
        $this->dados['parent'] = $this->getParams(0);
        $this->dados['form'] = $this->getParams(1);
        $this->dados['classInput'] = $this->getParams(2);

        $this->dados['rotina'] = $this->_rotina;
        $this->dados['tabela'] = $this->_tabela;
        $this->dados['uri']['get'] = "ibge/get/municipio";
        $this->dados['uri']['getlist'] = "ibge/getlist/municipio";

        $this->dados['filter'] = array(
            array('name'=>'ibge','title'=>'IBGE', 'col'=>'col-3'),
            array('name'=>'municipio','title'=>'Município', 'col'=>'col-9')
        );

        $this->dados['column'] = array(
            array('data'=>'ibge','title'=>'IBGE'),
            array('data'=>'municipio','title'=>'Município'),
            array('data'=>'uf','title'=>'UF')
        );

        $this->view();
    }

    public function getlist(){
        switch($this->getParams(0)){
            case 'municipio':
                echo json_encode($this->_listMinucipio());
                break;
            case 'estado':
                echo json_encode($this->_listEstado());
                break;
            default:
                break;
        }
    }

    private function _listEstado(){
        $api = new ApiEstado();
        return $api->getlist(new Estado('POST'));
    }

    private function _listMinucipio(){
        $api = new ApiMunicipio();
        return $api->getlist(new Municipio('POST'));
    }

    public function get(){
        switch($this->getParams(0)){
            case 'municipio':
                echo json_encode($this->_municipio());
                break;
            case 'estado':
                echo json_encode($this->_estado());
                break;
            default:
                break;
        }
    }

    private function _estado(){
        $api = new ApiEstado();
        return $api->get(new Estado('POST'));
    }

    private function _municipio(){
        $api = new ApiMunicipio();
        return $api->get(new Municipio('POST'));
    }
}