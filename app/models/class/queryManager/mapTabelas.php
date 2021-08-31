<?php

namespace models\class\queryManager;

use models\class\queryManager\Tabela;
use WeakMap;

abstract class MapTabelas{

    protected $tabelas;

    protected function __construct(){
        $this-> tabelas = new WeakMap();
        $this-> adicionarTabelas(
            new Tabela("USUARIO", "usr_nome", "usr_login")
        );
    }

    private function adicionarTabelas(Tabela ... $tabelas){
        foreach($tabelas as $tabela){
            ($this-> tabelas)-> offsetSet( $tabela, strtolower($tabela-> getNome()) ); 
        }
    }

}

?>
