<?php

namespace models\class\queryManager;

use models\class\queryManager\Tabela;
use SplObjectStorage;
use WeakMap;

abstract class MapTabelas{

    protected WeakMap $tabelas;
<<<<<<< HEAD
=======

    private Tabela $usuario;
    private Tabela $notaFiscal;
>>>>>>> 75684545782bd993b480f41dee342759386dc105

    protected function __construct(){
        $this-> tabelas = new WeakMap();
        
        $this-> usuario = new Tabela("USUARIO", "usr_nome", "usr_login");
        ($this-> tabelas)-> offsetSet( $this-> usuario, strtolower($this-> usuario-> getNome()) ); 

<<<<<<< HEAD
    private function adicionarTabelas(Tabela ... $tabelas){
        foreach($tabelas as $key => $tabela){
            //$this->tabelas[$tabela] = $tabela-> getNome();
            ($this-> tabelas)-> offsetSet( $tabela, strtolower($tabela-> getNome()) ); 
        }
        var_dump($this-> tabelas);
=======
        $this-> notaFiscal = new Tabela("NOTA_FISCAL", "NF_IF");
        ($this-> tabelas)-> offsetSet( $this-> notaFiscal, strtolower($this-> notaFiscal-> getNome()) ); 
 
>>>>>>> 75684545782bd993b480f41dee342759386dc105
    }

}

?>
