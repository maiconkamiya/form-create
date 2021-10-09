<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 27/09/2021
 * Time: 15:04
 */

namespace criativa\controller\painel;

use criativa\lib\Controller;

class homeController extends Controller {

    public function index(){
        $this->view();
    }
}