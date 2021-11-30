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
class Saida
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
        $this->tabela = $this->tabelaManager->getTabela("saida");
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
                    SAI.SAI_ID,
                    FIL.FIL_DESC,
                    SAI.SAI_LOTE,
                    SAI.SAI_DATA,
                    USR.USR_NOME,
                    NF.NF_NUM,
                    CONTA_QTDE_ITEMS_SAIDA(SAI_ID) AS SAI_QTDE,
                    VALOR_TOTAL_ITEMS_SAIDA(SAI_ID) AS SAI_VALOR
                from
                    saida sai
                    inner join usuario usr
                        on sai.usr_id = usr.usr_id
                    inner join nota_fiscal nf
                        on sai.nf_id = nf.nf_id
                    inner join filiais fil
                        on sai.fil_id = fil.fil_id
                "
            );
        else
            /*$retornoConsulta = $this->queryManager
                ->setAcao(Acao::SELECT)
                ->setTabela($this->tabela)
                ->setCondicao('SAI_ID', Operador::IGUAL, strval($identificador))
                ->queryExec();*/
            $retornoConsulta = $this->queryManager->getConexao()->query(
                "
                select
                    SAI.SAI_ID,
                    FIL.FIL_DESC,
                    SAI.SAI_LOTE,
                    SAI.SAI_DATA,
                    USR.USR_NOME,
                    NF.NF_NUM,
                    CONTA_QTDE_ITEMS_SAIDA(SAI_ID) AS SAI_QTDE,
                    VALOR_TOTAL_ITEMS_SAIDA(SAI_ID) AS SAI_VALOR
                from
                    saida sai
                    inner join usuario usr
                        on sai.usr_id = usr.usr_id
                    inner join nota_fiscal nf
                        on sai.nf_id = nf.nf_id
                    inner join filiais fil
                        on sai.fil_id = fil.fil_id
                where
                    sai.sai_id = $identificador
                "
            );

        if ($retornoConsulta->rowCount() > 0) {
            $response = ['error' => false, 'message' => ''];

            $response['data'] = $retornoConsulta->fetchAll();
        } else
            $response[] = ['error' => true, 'message' => 'Nenhum dado encontrado.'];

        return $response;
    }

    public function post($request, $idNotaFiscal)
    {
        $this->tabela->setColuna(
            'FIL_ID',
            'SAI_LOTE',
            'SAI_DATA',
            'USR_ID',
            'NF_ID'
        );

        $retornoConsulta = $this->queryManager
            ->setAcao(Acao::INSERT)
            ->setTabela($this->tabela)
            ->setValores(
                "'$request->FIL_ID'",
                "'$request->SAI_LOTE'",
                "'" . date('Y-m-d H:i:s') . "'",
                "'$request->USR_ID'",
                "'$idNotaFiscal'"
            )
            ->queryExec();

        return ($retornoConsulta)
            ? ['error' => false, 'message' => 'Operação realizada com sucesso.']
            : ['error' => true, 'message' => 'Não foi possível realizar a operação.'];
    }

    public function put($request, $identificador)
    {
        if (is_null($identificador))
            return ['error' => true, 'message' => 'Não foi possível realizar a operação.'];
        else {
            $tabela = clone $this->tabela;

            $tabela->setColuna(
                'TRS_ID',
                'ENT_DATA',
                'ENT_FRETE',
                'ENT_IMPOSTO',
                'USR_ID',
                'NF_ID'
            );

            $this->queryManager
                ->setAcao(Acao::UPDATE)
                ->setTabela($tabela)
                ->setValores(
                    "'$request->TRS_ID'",
                    "'" . date('Y-m-d H:i:s') . "'",
                    "'$request->ENT_FRETE'",
                    "'$request->ENT_IMPOSTO'",
                    "'$request->USR_ID'",
                    "'$request->NF_ID'"
                )
                ->setCondicao('ENT_ID', Operador::IGUAL, $identificador)
                ->queryExec();

            return ['error' => false, 'message' => 'Registro alterado com sucesso.'];
        }
    }

    public function delete($identificador)
    {
        if (is_null($identificador))
            return ['error' => true, 'message' => 'Não foi possível realizar a operação.'];
        else {
            $this->queryManager
                ->setAcao(Acao::DELETE)
                ->setTabela($this->tabela)
                ->setCondicao('ENT_ID', Operador::IGUAL, strval($identificador))
                ->queryExec();

            return ['error' => false, 'message' => 'Registro removido com sucesso.'];
        }
    }
}
