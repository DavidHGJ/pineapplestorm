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
class Produto implements iController
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
        $this->tabela = $this->tabelaManager->getTabela("produto");
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
                    PRD.PRD_ID,
                    PRD.PRD_DESC,
                    CAT.CAT_DESC,
                    FORN.FOR_NOME,
                    PRD.PRD_PESO,
                    PRD.PRD_STATUS,
                    CALCULA_QUANTIDADE_PRODUTO(PRD.PRD_ID) AS PRD_QTD,
                    PRD.PRD_REGDATE
                from
                    produto prd
                    inner join categoria cat
                        on prd.cat_id = cat.cat_id
                    inner join fornecedor forn
                        on prd.for_id = forn.for_id
                "
            );
        else
            /*$retornoConsulta = $this->queryManager
                ->setAcao(Acao::SELECT)
                ->setTabela($this->tabela)
                ->setCondicao('PRD_ID', Operador::IGUAL, strval($identificador))
                ->queryExec();*/
            $retornoConsulta = $this->queryManager->getConexao()->query(
                "
                select
                    PRD.PRD_ID,
                    PRD.PRD_DESC,
                    CAT.CAT_DESC,
                    FORN.FOR_NOME,
                    PRD.PRD_PESO,
                    PRD.PRD_STATUS,
                    CALCULA_QUANTIDADE_PRODUTO(PRD.PRD_ID) AS PRD_QTD,
                    PRD.PRD_REGDATE
                from
                    produto prd
                    inner join categoria cat
                        on prd.cat_id = cat.cat_id
                    inner join fornecedor forn
                        on prd.for_id = forn.for_id
                where
                    prd.prd_id = $identificador
                "
            );

        $this->queryManager->reset();

        if ($retornoConsulta->rowCount() > 0) {
            $response = ['error' => false, 'message' => ''];

            $response['data'] = $retornoConsulta->fetchAll();
        } else
            $response[] = ['error' => true, 'message' => 'Nenhum dado encontrado.'];

        return $response;
    }

    public function post($request)
    {
        $this->tabela->setColuna(
            'CAT_ID',
            'FOR_ID',
            'PRD_DESC',
            'PRD_PESO',
        );

        $retornoConsulta = $this->queryManager
            ->setAcao(Acao::INSERT)
            ->setTabela($this->tabela)
            ->setValores(
                "'$request->CAT_ID'",
                "'$request->FOR_ID'",
                "'$request->PRD_DESC'",
                "'$request->PRD_PESO'",
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
                'CAT_ID',
                'FOR_ID',
                'PRD_DESC',
                'PRD_PESO',
                'PRD_STATUS'
            );

            $this->queryManager
                ->setAcao(Acao::UPDATE)
                ->setTabela($tabela)
                ->setValores(
                    "'$request->CAT_ID'",
                    "'$request->FOR_ID'",
                    "'$request->PRD_DESC'",
                    "'$request->PRD_PESO'",
                    "'$request->PRD_STATUS'"
                )
                ->setCondicao('PRD_ID', Operador::IGUAL, $identificador)
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
                ->setCondicao('PRD_ID', Operador::IGUAL, strval($identificador))
                ->queryExec();

            return ['error' => false, 'message' => 'Registro removido com sucesso.'];
        }
    }
}
