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
        if( in_array(strtoupper($acao), array( Acao::SELECT, Acao::INSERT, Acao::UPDATE)) )
            $this-> acao = $acao;
        else if(empty($acao))
            throw new Exception("É necessário definir uma ação para executar a consulta.");
        else if(!is_null($this-> acao))
            throw new Exception("A ação \"" . $this-> acao . "\" já foi definida para esta query.");
        else
            throw new Exception("A ação \"" . $acao . "\" não é suportada.");
    }

    public function setTabelaPrincipal(Tabela $tabela){
        if(is_null($tabela))
            throw new Exception("Não foi possível definir tabela para consulta.");
        else if(($this-> tabelas)->count() > 0)
            throw new Exception("A tabela principal já foi definida.\n Não pode ser definida novamente.");

        ($this-> tabelas)-> offsetSet($tabela, "t" . strval(count($this-> tabelas) + 1));
        //$this-> tabelas[ $tabela ] = "t" + strval(count($this-> tabelas) + 1);
    }

    public function setCondicao(Tabela $tabela, Condicao $condicao){
        $apelido = "";

        if(($this->tabelas)-> offsetExists($tabela))
            $apelido = ($this->tabelas)-> offsetGet($tabela);

        if( ($this-> tabelas)-> count() == 1){
            if(is_null($condicao))
                throw new Exception("Não foi possível definir uma condição para query.");
            else{
                $this-> setApelidoCondicao($condicao, $apelido);
                $this-> condicao = $condicao;
            }
        }
    }

    private function setApelidoCondicao(Condicao $condicao, string $apelido){
        if( is_string($condicao->getTermoEsquerda()) )
            $condicao->addApelidoTermoEsquerda($apelido);
        else
            $this-> setApelidoCondicao($condicao->getTermoEsquerda(), $apelido);

        if( is_string($condicao->getTermoDireita()) )
            $condicao->addApelidoTermoDireita($apelido);
        else
            $this-> setApelidoCondicao($condicao->getTermoDireita(), $apelido);
    }

    public function getQuery(){
        $query = $this-> acao . " ";
        $colunas = "";
        $tabela = "";

        foreach($this-> tabelas as $key => $val){

            if($val == "t1"){
                $colunas = implode(", ", $key-> getColuna() );
                $tabela = $key-> getNome();
            }
        }

        $query .= $colunas . " from " . $tabela;

        return $query;
    }

    public function getTabela(){
        
    }

}

?>