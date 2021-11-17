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
            
            new Tabela("NOTA_FISCAL", "NF_IF", 'NF_NUM', 'NF_TIPO', 'NF_SERIE'),

            new Tabela("TRANSPORTADORA", "TRS_ID", "TRS_DESC", "TRS_NUM", "TRS_CEP", "TRS_CNPJ",
            "TRS_INSC", "TRS_STATUS", "TRS_COMPLEMENTO"),

            new Tabela("PRODUTO", "PRD_ID", "CAT_ID", "FOR_ID", "PRD_DESC", "PRD_PESO", "PRD_STATUS", "CALCULA_QUANTIDADE_PRODUTO(PRD_ID) AS PRD_QTD", "PRD_REGDATE"),

            new Tabela("FORNECEDOR", "FOR_ID", 'FOR_NOME', 'FOR_NUMERO', 'FOR_CEP', 'FOR_CNPJ', 'FOR_INSC', 'FOR_STATUS', 'FOR_COMPLEMENTO'),

            new Tabela('FILIAIS', 'FIL_ID', 'FIL_CNPJ', 'FIL_INSC', 'FIL_STATUS', 'FIL_DESC', 'FIL_CEP', 'FIL_NUM', 'FIL_COMPLEMENTO'),

            new Tabela('TIPO_CONTATO', 'TPC_ID', 'TPC_DESC'),

            new Tabela('CONTATO', 'CNT_ID', 'TPC_ID', 'CNT_DESC'),

            new Tabela('FILIAIX_X_CONTATO', 'FIL_ID', 'CNT_ID'),

            new Tabela('TRANSPORTADORA_X_CONTATO', 'TRS_ID', 'CNT_ID'),

            new Tabela('FORNECEDOR_X_CONTATO', 'FOR_ID', 'CNT_ID'),

            new Tabela('CATEGORIA', 'CAT_ID', 'CAT_DESC', 'CAT_STATUS'),

            new Tabela('USUARIO', 'USR_ID', 'USR_NOME', 'USR_LOGIN', 'USR_SENHA', 'USR_STATUS', 'USR_REGDATE', 'USR_DATANASCIMENTO'),

            new Tabela('GRUPO', 'GRU_ID', 'GRU_NOME', 'GRU_STATUS'),

            new Tabela('GRUPO_X_USUARIO', 'GRU_X_USR_ID', 'USR_ID', 'GRU_ID'),

            new Tabela('ENTRADA', 'ENT_ID', 'TRS_ID', 'ENT_DATA', 'CONTA_QTDE_ITEMS_ENTRADA(ENT_ID) AS ENT_QTDE', 'VALOR_TOTAL_ITEMS_ENTRADA(ENT_ID) AS ENT_VALOR', 'ENT_TOTAL', 'ENT_FRETE', 'ENT_IMPOSTO', 'USR_ID', 'NF_ID'),

            new Tabela('ITEM_ENTRADA', 'ITE_ID', 'PRD_ID', 'ITE_QTDE', 'ITE_VALOR', 'ITE_LOTE', 'NF_ID'),

            new Tabela('SAIDA', 'SAI_ID', 'FIL_ID', 'SAI_LOTE', 'CONTA_QTDE_ITEMS_SAIDA(SAI_ID) AS SAI_QTDE', 'VALOR_TOTAL_ITEMS_SAIDA(SAI_ID) AS SAI_VALOR', 'USR_ID', 'NF_ID'),

            new Tabela('ITEM_SAIDA', 'ITS_ID', 'SAI_ID', 'PRD_ID', 'SAI_LOTE', 'SAI_QTDE', 'SAI_VALOR', 'NF_ID')
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