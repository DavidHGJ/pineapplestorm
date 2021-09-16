<?php

namespace models\class\queryManager;

use Exception;
use models\class\queryManager\mapTabelas;
<<<<<<< HEAD
use stdClass;
=======
>>>>>>> 75684545782bd993b480f41dee342759386dc105
use WeakMap;

class TableManager extends MapTabelas{

    /** Instância do gerenciador de query */
    private static $TableManager = null;

    private function __construct(){
        parent::__construct();
    }

    /**
     * Retorna uma instância do gerenciador de query's.
     */
    public static function getInstance(){
        if(static::$TableManager === null)
            static::$TableManager = new self();

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