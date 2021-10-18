<?php

namespace models\class\queryManager;

use models\class\util\Conexao;
use models\class\queryManager\Query;
use models\class\queryManager\Tabela;
use Exception;

/**
 * Representa o gerenciador de query's no sistema.
 * 
 * Exemplos práticos da biblioteca gerenciadora de query's.
 * 
 * Select:</br>
 * $queryManager->
 *   setAcao(Acao::SELECT)->
 *   setTabela($tabela)->
 *   setCondicao("campo", Operador::IGUAL, "valor")->
 *   addCondicao("AND", "campo", Operador::IGUAL, "valor2");
 * 
 * Update:
 * $queryManager->
 *   setAcao(Acao::UPDATE)->
 *   setTabela($tabela)->
 *   setValores(
 *       $con->quote("teste"), 
 *       $con->quote("adw"), 
 *       $con->quote("adawd"), 
 *       $con->quote("adawd"), 
 *       $con->quote("awdaw")
 *   )->
 *   setCondicao("campo", Operador::IGUAL, "valor");
 * 
 * Delete:
 * $queryManager-> 
 *   setAcao(Acao::DELETE)->
 *   setTabela($tabela)->
 *   setCondicao("id", Operador::IGUAL, "1");
 * 
 * @androide23
 */
class QueryManager{

    /** Instância do gerenciador de query */
    private static $QueryManager = null;
    /** Sessão de conexão com o banco de dados */
    private static $conexao = null;
    /** Estrutura da query */
    private static $query = null;

    private function __construct(){
        static::$conexao = ( new Conexao("localhost", "pine", "root", "") )-> getConexao();
        static::$query = new Query();
    }

    private function __close(){}
    
    public function __wakeup(){
        throw new Exception("Não foi possível recuperar instância.");    
    }

    /**
     * Retorna uma instância do gerenciador de query's.
     */
    public static function getInstance(){
        if(static::$QueryManager === null)
            static::$QueryManager = new static();

        return static::$QueryManager;
    }

    /** 
     * Retorna a conexão com o banco de dados.
     * 
     * @return static::Conexao conexao
     */
    public function getConexao(){
        return static::$conexao;
    }

    /**
     * Atribui uma ação para a query.
     * 
     * @return QueryManager Instância do gerenciador de query
     */
    public function setAcao(string $acao){
        static::$query-> setAcao($acao);
        return $this;
    }

    /**
     * Atribui a tabela para a query.
     * 
     * @return QueryManager Instância do gerenciador de query
     */
    public function setTabela(Tabela $tabela){
        static::$query-> setTabelaPrincipal($tabela);
        return $this;
    }

    /** 
     * Atribui condição para a query.  
     * 
     * @return QueryManager Instância do gerenciador de query
     */
    public function setCondicao(){
        if(static::$query-> getAcao() == Acao::INSERT)
            throw new Exception("Só é possível atribuir condição quando a ação for de 'SELECT', 'UPDATE' ou 'DELETE'");

        $args = func_get_args();
        static::$query-> setCondicao($args);
        return $this;
    }

    /**
     * Adiciona uma condição à query.
     * 
     * @return QueryManager Instância do gerenciador de query
     */
    public function addCondicao(){
        if(static::$query-> getAcao() == Acao::INSERT)
            throw new Exception("Só é possível adicionar condição quando a ação for de 'SELECT', 'UPDATE' ou 'DELETE'");

        $args = func_get_args();
        static::$query-> addCondicao($args);
        return $this;
    }

    /**
     * Seta valores para realizar insert ou update.
     * @param mixed $valores valores para insert/update
     * 
     * @return QueryManager Instância do gerenciador de query
     */
    public function setValores(mixed ... $valores){
        static::$query-> setValores($valores);
        return $this;
    }

    /**
     * Executa a query que foi construída.
     * 
     * @return PDO resultado da consulta
     */
    public function queryExec(){
        return $this-> getConexao()-> query( $this-> queryDebug() );
    }

    /**
     * Retorna o script da query construída.
     * 
     * @return String script da query
     */
    public function queryDebug(){
        return strtoupper(trim(static::$query-> getQuery()));
    }
}
?>