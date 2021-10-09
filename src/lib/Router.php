<?php
/**
 * Created by PhpStorm.
 * User: Vendas
 * Date: 01/06/2017
 * Time: 08:48
 */

namespace criativa\lib;

class Router {
    protected $routers = array(
        'painel' => 'painel',
    );

    protected $routerOnDefault = 'painel';

    protected $onDefault = true;
}