<?php

namespace models\class\queryManager;

use models\class\util\Conexao;
use models\class\queryManager\Query;
use models\class\queryManager\Tabela;
use Exception;

/**
 * Representa o gerenciador de query's no sistema.
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
        static::$conexao = ( new Conexao("sql10.freemysqlhosting.net", "sql10432719", "sql10432719", "hM6GcxNdEw") )-> getConexao();
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

    public function getConexao(){
        return static::$conexao;
    }

    public function setAcao(string $acao){
        static::$query-> setAcao($acao);
        return $this;
    }

    public function setTabela(Tabela $tabela){
        static::$query-> setTabelaPrincipal($tabela);
        return $this;
    }

    public function queryExec(){
        return $this-> getConexao()-> query( $this-> queryDebug() );
    }

    public function queryDebug(){
        return strtoupper(static::$query-> getQuery());
    }

}

?>