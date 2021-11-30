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
class Transportadora implements iController
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
        $this->tabela = $this->tabelaManager->getTabela("transportadora");
    }

    public function get($identificador)
    {
        if (is_null($identificador))
            $retornoConsulta = $this->queryManager
                ->setAcao(Acao::SELECT)
                ->setTabela($this->tabela)
                ->queryExec();
        else
            $retornoConsulta = $this->queryManager
                ->setAcao(Acao::SELECT)
                ->setTabela($this->tabela)
                ->setCondicao('TRS_ID', Operador::IGUAL, strval($identificador))
                ->queryExec();

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
            'TRS_DESC',
            'TRS_NUM',
            'TRS_CEP',
            'TRS_CNPJ',
            'TRS_INSC',
            'TRS_STATUS',
            'TRS_COMPLEMENTO'
        );

        /*$retornoConsulta = $this->queryManager
            ->setAcao(Acao::INSERT)
            ->setTabela($this->tabela)
            ->setValores(
                '$request->TRS_DESC',
                '$request->TRS_NUM',
                '$request->TRS_CEP',
                '$request->TRS_CNPJ',
                '$request->TRS_INSC',
                '$request->TRS_STATUS',
                '$request->TRS_COMPLEMENTO'
            )
            ->queryExec();*/

        $retornoConsulta = $this->queryManager->getConexao()->query(
            "call transportadora_insert(
                '$request->TRS_DESC',
                '$request->TRS_NUM',
                '$request->TRS_CEP',
                '$request->TRS_CNPJ',
                '$request->TRS_INSC',
                '$request->TRS_STATUS',
                '$request->TRS_COMPLEMENTO'
            )"
        );

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
                'TRS_DESC',
                'TRS_NUM',
                'TRS_CEP',
                'TRS_CNPJ',
                'TRS_INSC',
                'TRS_STATUS',
                'TRS_COMPLEMENTO'
            );

            $this->queryManager
                ->setAcao(Acao::UPDATE)
                ->setTabela($tabela)
                ->setValores(
                    '$request->TRS_DESC',
                    '$request->TRS_NUM',
                    '$request->TRS_CEP',
                    '$request->TRS_CNPJ',
                    '$request->TRS_INSC',
                    '$request->TRS_STATUS',
                    '$request->TRS_COMPLEMENTO'
                )
                ->setCondicao('TRS_ID', Operador::IGUAL, $identificador)
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
                ->setCondicao('TRS_ID', Operador::IGUAL, strval($identificador))
                ->queryExec();

            return ['error' => false, 'message' => 'Registro removido com sucesso.'];
        }
    }
}
