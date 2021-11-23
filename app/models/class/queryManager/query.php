<?php

namespace models\class\queryManager;

use models\class\queryManager\Acao;
use models\class\queryManager\Tabela;
use models\class\queryManager\Condicao;
use Exception;
use WeakMap;

/**
 * Representa a query no sitema.
 * 
 * @androide23
 */
class Query{

    /** Ação da query(SELECT/UPDATE/INSERT/DELETE). */
    private $acao = null;
    /** Armazena as tabelas utilizadas na query. */
    private $tabelas = null;
    /** Armazena as condições da query. */
    private $condicao = null;
    /** Armazena os valores para realizar INSERT/UPDATE. */
    private $valores = null;

    public function __construct(){
        $this-> tabelas = new WeakMap();
    }

    /** 
     * Atribui uma ação para a query. 
     * */
    public function setAcao(String $acao){
        if( in_array(strtoupper($acao), array( Acao::SELECT, Acao::INSERT, Acao::UPDATE, Acao::DELETE)) )
            $this-> acao = $acao;
        else if(empty($acao))
            throw new Exception("É necessário definir uma ação para executar a consulta.");
        else if(!is_null($this-> acao))
            throw new Exception("A ação \"" . $this-> acao . "\" já foi definida para esta query.");
        else
            throw new Exception("A ação \"" . $acao . "\" não é suportada.");
    }

    /**
     * Defini a tabela principal da query.
     */
    public function setTabelaPrincipal(Tabela $tabela){
        if(is_null($tabela))
            throw new Exception("Não foi possível definir tabela para consulta.");
        else if(($this-> tabelas)->count() > 0)
            throw new Exception("A tabela principal já foi definida.\n Não pode ser definida novamente.");

        ($this-> tabelas)-> offsetSet($tabela, "t" . strval(count($this-> tabelas) + 1));
    }

    /**
     * Atribui uma condição para a query.
     */
    public function setCondicao(){
        if($this-> acao == Acao::INSERT)
            throw new Exception("Não é possível adicionar condição quando a ação for definida como INSERT");

        $args = func_get_args();
        $aux = $args[0];

        switch( sizeof($aux) ){
            case 1:
                if(is_object($aux[0]))
                    $this-> condicao = new Condicao($aux[0]);
                else
                    throw new Exception("Só é possível passar parâmetro unico do tipo Condicao");
            break;

            case 3:
                if(is_null($this-> condicao))
                    $this-> condicao = new Condicao($aux[0], $aux[1], $aux[2]);
                else
                ($this-> condicao)-> addExpressao($aux[0], $aux[1], $aux[2]);    
            break;

            case 4:
                ($this-> condicao)-> addExpressao($aux[0], $aux[1], $aux[2], $aux[3]);
            break;
            
            case 6: //to do: Quando houver mais de uma tabela na query, será necessário especificar de qual tabela é o campo,
                    //ser implementado de acordo com o avanço do projeto.
            break;

            default:
                throw new Exception("Quantidade de parâmetros inválida");
        }
    }

    /**
     * Adiciona uma condição a query.
     */
    public function addCondicao(){
        $args = func_get_args();
        $aux = $args[0];

        $this-> setCondicao($aux);
    }

    /**
     * Seta os valores que serão realizados o insert ou update deles.
     */
    public function setValores($valores){
        if($this-> acao == Acao::SELECT)
            throw new Exception("Só é possível atribuir valores quando a ação for 'INSERT' ou 'UPDATE'.");

        $this-> valores = $valores;
    }

    /*
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
    */
    /**
     * Realiza a montagem de query e retorna ela construída.
     * 
     * @return String query contruída
     */
    public function getQuery(){
        switch($this-> acao){

            case Acao::SELECT:{
                $query = $this-> acao . " ";
                $colunas = "";
                $tabela = "";
                $apelido = "";

                foreach($this-> tabelas as $key => $val){
                    if($val == "t1"){
                        $apelido = $val;
                        $colunas = implode(", ", $key-> getColuna() );
                        $tabela = $key-> getNome();
                    }
                }

                $query .= $colunas . " from " . $tabela . " " . $apelido . " "; 

                if(!is_null($this-> condicao))
                    $query .= "WHERE " . ($this-> condicao)-> getExpressaoCompleta();

                break;
            }
            case Acao::INSERT:{
                $query = $this-> acao . " ";
                $colunas = "";
                $tabela = "";
                
                foreach($this-> tabelas as $key => $val){
                    if($val == "t1"){
                        if(count($this-> getValores()) != $key-> contaColunas())
                            throw new Exception("Quantidade de parâmetros passados são inválidos.");

                        $apelido = $val;
                        $colunas = implode(", ", $key-> getColuna() );
                        $tabela = $key-> getNome();

                        $query .= $tabela . "(" . $colunas . ") ";
                    }
                }

                $query .= "values(" . implode(", ", $this-> getValores()) . ")";

                break;
            }
            case Acao::UPDATE:{
                $query = $this-> acao . " ";
                $colunas = "";
                $tabela = "";
                
                foreach($this-> tabelas as $key => $val){
                    if($val == "t1"){
                        if(count($this-> getValores()) != $key-> contaColunas())
                            throw new Exception("Quantidade de parâmetros passados são inválidos.");

                        $apelido = $val;
                        $updateSets = array();

                        foreach(array_combine($key-> getColuna(), $this-> valores) as $k => $v){
                            array_push($updateSets, $k . " = " . $v);
                        }

                        $colunas = implode(", ", $updateSets );
                        $tabela = $key-> getNome();

                        $query .= $tabela . " set " . $colunas . " ";

                        if(!is_null($this-> condicao))
                            $query .= "WHERE " . ($this-> condicao)-> getExpressaoCompleta();
                    }
                }

                break;
            }
            case Acao::DELETE:{
                $query = $this-> acao . " ";
                $colunas = "";
                $tabela = "";
                $apelido = "";

                foreach($this-> tabelas as $key => $val){
                    if($val == "t1"){
                        $apelido = $val;
                        $colunas = implode(", ", $key-> getColuna() );
                        $tabela = $key-> getNome();
                    }
                }

                if( is_null($this-> condicao) )
                    throw new Exception("Para realizar o delete é necessário adicionar uma condição.");

                $query .= "from " . $tabela . " WHERE " . ($this-> condicao)-> getExpressaoCompleta(); 

                break;
            }
            default:{
                throw new Exception("Ação atribuída não foi identificada ao gerar a query.");
            }

        }

        return $query;
    }

    /**
     * Retorna a ação da query.
     * 
     * @return Acao ação da query
     */
    public function getAcao(){
        return $this-> acao;      
    }

    /**
     * Retorna os valores que serão utilizados para realizar insert ou update.
     * 
     * @return String[] valores
     */
    public function getValores(){
        return $this-> valores;
    }

    public function reset(){
         unset($this-> acao);
      
         unset($this-> tabelas);
        
         unset($this-> condicao);
       
         unset($this-> valores);
    }
}

?>