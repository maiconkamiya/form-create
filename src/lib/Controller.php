<?php
/**
 * Created by PhpStorm.
 * User: Vendas
 * Date: 01/06/2017
 * Time: 08:48
 */

namespace criativa\lib;


class Controller extends System {
    public $dados;
    public $layout = '_layout';
    public $path;
    public $pathRender;

    public $captionController;
    public $captionAction;
    public $captionParams;

    //Metatag
    public $title;
    public $description;
    public $keywords;
    public $image;
    public $movie;

    public function __construct($loadParametro = true){
        parent::__construct();

        //if ($loadParametro)
            //new ApiParametro();
    }

    public function view($name = null){
        $this->setSEO();

        //Run function set path
        $this->_setPath($name);

        if (is_null($this->layout)) {
            $this->render();
        } else {
            $this->layout = "src/content/{$this->getArea()}/shared/{$this->layout}.phtml";
            if (file_exists($this->layout)) {
                $this->render($this->layout);
            } else {
                define('ERROR', "Não foi localizado o layout! {$this->layout}");
                header("HTTP/1.0 404 Not Found");
                echo ERROR;
                //include('content/' . $this->getArea() . '/shared/404.phtml');
                exit();
            }
        }
    }

    public function render($view = null){
        if (is_array($this->dados) && count($this->dados) > 0) {
            extract($this->dados, EXTR_PREFIX_ALL, 'view');
            extract(array(
                'controller' => (is_null($this->captionController) ? '' : $this->captionController),
                'action' => (is_null($this->captionAction) ? '' : $this->captionAction),
                'params' => (is_null($this->captionParams) ? '' : $this->captionParams)
            ), EXTR_PREFIX_ALL, 'caption');
        }

        if (!is_null($view) && is_array($view)) {
            foreach ($view as $l) {
                include($l);
            }
        } elseif (is_null($view) && is_array($this->path)) {
            foreach ($this->path as $l) {
                include($l);
            }
        } else {
            $file = is_null($view) ? $this->path : $view;
            file_exists($file) ? include ($file) : die($file);
        }
    }

    private function _setPath($render) {
        if (is_array($render)){
            foreach ($render as $l) {
                $path = 'src/view/' . $this->getArea() . '/' . $this->getController() . '/' . $l . '.phtml';
                $this->_fileExists($path);
                $this->path[] = $path;
            }
        } else {
            //Set path render
            $this->pathRender = is_null($render) ? $this->getAction() : $render;
            //Set path
            $this->path = 'src/view/' . $this->getArea() . '/' . $this->getController() . '/' . $this->pathRender . '.phtml';
            $this->_fileExists($this->path);
        }
    }

    private function _fileExists($file) {
        if (!file_exists($file)) {
            define('ERROR', "Não foi localizado a view!\n{$file}");
            header("HTTP/1.0 404 Not Found");
            echo ERROR;
            //include('content/' . $this->getArea() . '/shared/404.phtml');
            exit();
        }
    }

    private function setSEO(){
        if (empty($this->title)){ $this->title = TITLE; }
        if (empty($this->description)){ $this->description = DESCRIPTION; }
        if (empty($this->keywords)){ $this->keywords = KEYWORDS; }

        $this->title = strip_tags($this->title);
        $this->description = strip_tags($this->description);
        $this->keywords = strip_tags($this->keywords);
    }

    /*Check Permissao*/
    protected function _checkPermissao($id){
        //$check = new ApiRotina();

        //if ($check->checkPermissao($id)){
        //    $this->view('../sessao/noacess');
        //    exit();
        //}
    }
}