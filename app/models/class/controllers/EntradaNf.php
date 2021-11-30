<?php

namespace models\class\controllers;

use models\class\controllers\iController;
use models\class\queryManager\Acao;
use models\class\queryManager\Operador;
use models\class\queryManager\QueryManager;
use models\class\queryManager\Tabela;
use models\class\queryManager\TableManager;

/**
 *## Classe responsável pelo endpoint das transportadora.
 */
class EntradaNf
{

    private QueryManager $queryManager;
    private TableManager $tabelaManager;
    private Tabela $tabela;

    /**
     *## Construtor
     */
    public function __construct()
    {
        $this->queryManager = QueryManager::getInstance();
        $this->tabelaManager = TableManager::getInstance();
        $this->tabela = $this->tabelaManager->getTabela("entrada");
    }

    public function get($identificador)
    {
        if (is_null($identificador))
            /*$retornoConsulta = $this->queryManager
                ->setAcao(Acao::SELECT)
                ->setTabela($this->tabela)
                ->queryExec();*/
            $retornoConsulta = $this->queryManager->getConexao()->query(
                "
                select
                    ENT.ENT_ID,
                    TRS.TRS_DESC,
                    ENT.ENT_DATA,
                    ENT.ENT_FRETE,
                    ENT.ENT_IMPOSTO,
                    ENT.USR_ID,
                    NF.NF_NUM,
                    CONTA_QTDE_ITEMS_ENTRADA(ENT_ID) AS ENT_QTDE,
                    VALOR_TOTAL_ITEMS_ENTRADA(ENT_ID) AS ENT_VALOR
                from
                    entrada ent
                    inner join transportadora trs
                        on ent.trs_id = trs.trs_id
                    inner join nota_fiscal nf
                        on ent.nf_id = nf.nf_id
                "
            );
        else
            /*$retornoConsulta = $this->queryManager
                ->setAcao(Acao::SELECT)
                ->setTabela($this->tabela)
                ->setCondicao('ENT_ID', Operador::IGUAL, strval($identificador))
                ->queryExec();*/
            $retornoConsulta = $this->queryManager->getConexao()->query(
                "
                select
                    ENT.ENT_ID,
                    TRS.TRS_DESC,
                    ENT.ENT_DATA,
                    ENT.ENT_FRETE,
                    ENT.ENT_IMPOSTO,
                    ENT.USR_ID,
                    NF.NF_NUM,
                    CONTA_QTDE_ITEMS_ENTRADA(ENT_ID) AS ENT_QTDE,
                    VALOR_TOTAL_ITEMS_ENTRADA(ENT_ID) AS ENT_VALOR
                from
                    entrada ent
                    inner join transportadora trs
                        on ent.trs_id = trs.trs_id
                    inner join nota_fiscal nf
                        on ent.nf_id = nf.nf_id
                where
                    ent_id = $identificador
                "
            );

        if ($retornoConsulta->rowCount() > 0) {
            $response = ['error' => false, 'message' => 'Dados encontrados com sucesso.'];

            $response['data'] = $retornoConsulta->fetchAll();
        } else
            $response[] = ['error' => true, 'message' => 'Nenhum dado encontrado.'];

        return $response;
    }

    public function post($request)
    {
        $notaFiscal = new NotaFiscal;

        $notaFiscal->post($request);

        $idNotaFiscal = QueryManager::getInstance()->getConexao()->lastInsertId();

        unset($notaFiscal);

        $entrada = new Entrada;

        $entrada->post($request, $idNotaFiscal);

        $idEntrada = QueryManager::getInstance()->getConexao()->lastInsertId();

        unset($entrada);

        foreach($request->ITENS as $item)
        {
            $itemEntrada = new ItemEntrada;

            $itemEntrada->post($item, $idEntrada);

            unset($itemEntrada);
        }

        return ['error' => false, 'message' => 'Operação realizada com sucesso.'];
    }
}
