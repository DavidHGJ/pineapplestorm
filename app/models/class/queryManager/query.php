<?php

namespace models\class\queryManager;

use models\class\queryManager\Acao;
use models\class\queryManager\Tabela;
use models\class\queryManager\Condicao;
use Exception;
use WeakMap;

class Query{

    private $acao = null;
    private $tabelas = null;
    private $condicao = null;

    public function __construct(){
        $this-> tabelas = new WeakMap();
    }

    public function setAcao(String $acao){
        if( in_array($acao, array(Acao::SELECT, Acao::INSERT, Acao::UPDATE)) )
            $this-> action = $acao;
        else if(!is_null($acao))
            throw new Exception("A ação \"" + $this-> acao + "\" já foi definida para esta query.");
        else
            throw new Exception("A ação \"" + $acao + "\" não é suportada.");
    }

    public function setTabelaPrincipal(Tabela $tabela){
        if(is_null($tabela))
            throw new Exception("Não foi possível definir tabela para consulta.");
        else if(!is_null($this-> tabelas))
            throw new Exception("A tabela principal já foi definida.\n Não pode ser definida novamente.");

        $this-> tabelas[ "t" + strval(count($this-> tabelas) + 1) ] = $tabela;
    }

}

?>