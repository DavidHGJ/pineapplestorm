<?php

namespace models\class\queryManager;

use models\class\queryManager\Tabela;
use SplObjectStorage;

/**
 * Classe abstrata que instancia todas as tabelas a serem utilizadas no sistema.
 * 
 * @androide23
 */
abstract class MapTabelas{
    /** Armazena as tabelas a serem utilizadas no sistema. */
    protected SplObjectStorage $tabelas;

    protected function __construct(){
        $this-> tabelas = new SplObjectStorage();
        
        $this-> adicionarTabelas(
            new Tabela("USUARIO", "usr_nome", "usr_login", "usr_senha", "usr_status", "usr_regdate"),
            
            new Tabela("NOTA_FISCAL", "NF_IF"),

            new Tabela("TRANSPORTADORA", "TRS_ID", "TRS_DESC", "TRS_NUM", "TRS_CEP", "TRS_CNPJ",
            "TRS_INSC", "TRS_STATUS", "TRS_COMPLEMENTO"),

            new Tabela("PRODUTO", "PRD_ID", "CAT_ID", "FOR_ID", "PRD_DESC", "PRD_PESO", "PRD_STATUS", "PRD_QTDE", "PRD_REGDATE"),

            new Tabela("FORNECEDOR", "FOR_ID", 'FOR_NOME', 'FOR_NUMERO', 'FOR_CEP', 'FOR_CNPJ', 'FOR_INSC', 'FOR_STATUS', 'FOR_COMPLEMENTO'),

            new Tabela('FILIAIS', 'FIL_ID', 'FIL_CNPJ', 'FIL_INSC', 'FIL_STATUS', 'FIL_DESC', 'FIL_CEP', 'FIL_NUM', 'FIL_COMPLEMENTO')
        );
    }
    
    /** 
     * Adiciona tabelas à SplObjectStorage
     */
    private function adicionarTabelas(Tabela ... $tabelas){
        foreach($tabelas as $key => $tabela)
            ($this-> tabelas)-> offsetSet( $tabela, strtolower($tabela-> getNome()) ); 
    }
}