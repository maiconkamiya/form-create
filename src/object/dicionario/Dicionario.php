<?php
/**
 * Created by PhpStorm.
 * User: maico
 * Date: 28/09/2021
 * Time: 10:18
 */

namespace criativa\object\dicionario;

use criativa\lib\Obj;

class Dicionario extends Obj {
    public $rowid;
    public $codrotina;
    public $tabela;
    public $coluna;
    public $tipo;
    public $sqlConsulta;
    public $sqlLista;
    public $sqlValidacao;
    public $flagFiltroPesquisa;
    public $flagResultadoPresquisa;
    public $flagFormulario;
    public $flagObrigatorio;
    public $nome;
    public $descricao;
    public $grupo;
}