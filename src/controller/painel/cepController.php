<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 30/09/2021
 * Time: 11:27
 */

namespace criativa\controller\painel;

use criativa\lib\Controller;
use Exception;
use SoapClient;

class cepController extends Controller {
    public function consulta(){
        $wsdl = "https://www.byjg.com.br/site/webservice.php/ws/cep?WSDL"; // Or "http://provider.com/api/api.wsdl"

        try {
            $std = new \stdClass();

            if (is_null($this->getParams(0)) || $this->getParams(0)==''){
                $std->error = 'Não foi informado o CEP';
            }

            $soapClient = new SoapClient($wsdl);
            $string = $soapClient->obterLogradouroAuth($this->getParams(0),SOAPCEPUSER,SOAPCEPPWD);
            $string = explode(',', $string);

            if (count($string) == 5){
                $std->endereco = trim(isset($string[0]) ? $string[0] : '');
                $std->bairro = trim(isset($string[1]) ? $string[1] : '');
                $std->municipio = trim(isset($string[2]) ? $string[2] : '');
                $std->uf = trim(isset($string[3]) ? $string[3] : '');
                $std->ibge = trim(isset($string[4]) ? $string[4] : '');
            } else {
                $std->error = $string[0];
            }

            echo json_encode($std);
        } catch(Exception $e) {
            $std = new \stdClass();
            $std->error = $e;

            echo json_encode($std);
        }
    }
}