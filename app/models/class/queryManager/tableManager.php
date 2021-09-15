<?php

namespace models\class\queryManager;

use Exception;
use models\class\queryManager\mapTabelas;
use WeakMap;

class TableManager extends mapTabelas{

    /** Instância do gerenciador de query */
    private static $TableManager = null;

    private function __construct(){
        parent::__construct();
        var_dump($this-> tabelas);exit;
    }

    /**
     * Retorna uma instância do gerenciador de query's.
     */
    public static function getInstance(){
        if(static::$TableManager === null)
            static::$TableManager = new static();

        return static::$TableManager;
    }

    public function getTabela(String $nome){
        if( count($this->tabelas) == 0)
            throw new Exception("Não existe tabela mapeada para retorna-la.");

        foreach($this-> tabelas as $tabela => $nomeTabela){
            if( strtoupper($nome) == strtoupper($nomeTabela) )
                return clone $tabela;
        }
        
        throw new Exception("Não foi possível encontrar a tabela especificada.");
    }

}

?>