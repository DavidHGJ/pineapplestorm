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
class Filial implements iController
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
        $this->tabela = $this->tabelaManager->getTabela("filiais");
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
                ->setCondicao('FIL_ID', Operador::IGUAL, strval($identificador))
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
            'FIL_CNPJ',
            'FIL_INSC',
            'FIL_STATUS',
            'FIL_DESC',
            'FIL_CEP',
            'FIL_NUM',
            'FIL_COMPLEMENTO'
        );

        $retornoConsulta = $this->queryManager
            ->setAcao(Acao::INSERT)
            ->setTabela($this->tabela)
            ->setValores(
                "'$request->FIL_CNPJ'",
                "'$request->FIL_INSC'",
                "'$request->FIL_STATUS'",
                "'$request->FIL_DESC'",
                "'$request->FIL_CEP'",
                "'$request->FIL_NUM'",
                "'$request->FIL_COMPLEMENTO'"
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
                'FIL_CNPJ',
                'FIL_INSC',
                'FIL_STATUS',
                'FIL_DESC',
                'FIL_CEP',
                'FIL_NUM',
                'FIL_COMPLEMENTO'
            );

            $this->queryManager
                ->setAcao(Acao::UPDATE)
                ->setTabela($tabela)
                ->setValores(
                    "'$request->FIL_CNPJ'",
                    "'$request->FIL_INSC'",
                    "'$request->FIL_STATUS'",
                    "'$request->FIL_DESC'",
                    "'$request->FIL_CEP'",
                    "'$request->FIL_NUM'",
                    "'$request->FIL_COMPLEMENTO'"
                )
                ->setCondicao('FIL_ID', Operador::IGUAL, $identificador)
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
                ->setCondicao('FIL_ID', Operador::IGUAL, strval($identificador))
                ->queryExec();

            return ['error' => false, 'message' => 'Registro removido com sucesso.'];
        }
    }
}
