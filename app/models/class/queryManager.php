<?php

use models\class\conexao;

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

    private function __construct(){
        static::$conexao = ( new Conexao("localhost", "PineAppleStorm", "root", "123") )-> getConexao();
    }

    private function __clonse(){}
    
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
     * Retorna resultado de um simples select com os dados passados por parâmetro.
     * 
     * @param $tabelaNome String
     *      nome da tabela
     * @param $colunas
     *      nome das colunas em String única ou em array
     * @param $condicoes
     *      condições em String única ou em array
     */
    public function getSimpleSelect($tabelaNome, $colunas, ...$condicoes = null){
        $query = "SELECT ";

        if( is_array($colunas) )
            foreach($colunas as $dados)
                $query += $dados + ", ";
        else
            $query += $colunas;

        $query += "FROM " + $tabelaNome + " ";

        /* Se houver condições serão adicionadas na query */
        if( !is_null($condicoes) ){
            $query += "WHERE ";

            if( is_array($colunas) )
                foreach($colunas as $dados)
                    $query += $dados + "and ";
            else
                $query += $colunas;
        }
        
        return ($this->conexao)-> query($query);
    }

}

?>