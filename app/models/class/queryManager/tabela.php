<?php

namespace models\class\queryManager;

class tabela{

    private $nome = null;
    private $coluna = null;

    public function __construct(String $nome, String ... $coluna){
        $this-> nome = $nome;
        $this-> coluna = $coluna;
    }

    public function getNome(){
        return $this-> nome;
    }

    public function getColuna(){
        return $this-> coluna;
    }

}

?>