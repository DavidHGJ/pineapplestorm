<?php

namespace models\class\queryManager;

use models\class\queryManager\Tabela;
use WeakMap;

abstract class MapTabelas{

    protected WeakMap $tabelas;

    private Tabela $usuario;
    private Tabela $notaFiscal;

    protected function __construct(){
        $this-> tabelas = new WeakMap();
        
        $this-> usuario = new Tabela("USUARIO", "usr_nome", "usr_login");
        ($this-> tabelas)-> offsetSet( $this-> usuario, strtolower($this-> usuario-> getNome()) ); 

        $this-> notaFiscal = new Tabela("NOTA_FISCAL", "NF_IF");
        ($this-> tabelas)-> offsetSet( $this-> notaFiscal, strtolower($this-> notaFiscal-> getNome()) ); 
 
    }

}

?>
