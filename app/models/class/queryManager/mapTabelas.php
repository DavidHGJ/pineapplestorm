<?php

namespace models\class\queryManager;

use models\class\queryManager\Tabela;
use SplObjectStorage;
use WeakMap;

abstract class MapTabelas{

    protected SplObjectStorage $tabelas;

    protected function __construct(){
        $this-> tabelas = new SplObjectStorage();
        
        $this-> adicionarTabelas(
            new Tabela("USUARIO", "usr_nome", "usr_login", "usr_senha", "usr_status", "usr_regdate"),
            
            new Tabela("NOTA_FISCAL", "NF_IF"),

            new Tabela("TRANSPORTADORA", "TRS_ID", "TRS_CIDADE", "TRS_DESC", "TRS_ENDERECO", 
                "TRS_NUM","TRS_BAIRRO", "TRS_CEP", "TRS_CNPJ", "TRS_INSC", "TRS_CONTATO", "TRS_TEL", "TRS_STATUS")
        );
    }
    
    private function adicionarTabelas(Tabela ... $tabelas){
        foreach($tabelas as $key => $tabela)
            ($this-> tabelas)-> offsetSet( $tabela, strtolower($tabela-> getNome()) ); 
    }
}