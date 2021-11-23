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
class Fornecedor implements iController
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
        $this->tabela = $this->tabelaManager->getTabela("fornecedor");
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
                ->setCondicao('FOR_ID', Operador::IGUAL, strval($identificador))
                ->queryExec();

               $this->queryManager
                ->setAcao(Acao::SELECT)
                ->setTabela($this->tabela)
                ->setCondicao('FOR_ID', Operador::IGUAL, strval($identificador))
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
            'FOR_NOME',
            'FOR_NUMERO',
            'FOR_CEP',
            'FOR_CNPJ',
            'FOR_INSC',
            'FOR_STATUS',
            'FOR_COMPLEMENTO'
        );

        $retornoConsulta = $this->queryManager
            ->setAcao(Acao::INSERT)
            ->setTabela($this->tabela)
            ->setValores(
                "'$request->FOR_NOME'",
                "'$request->FOR_NUMERO'",
                "'$request->FOR_CEP'",
                "'$request->FOR_CNPJ'",
                "'$request->FOR_INSC'",
                "'$request->FOR_STATUS'",
                "'$request->FOR_COMPLEMENTO'"
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
                'FOR_NOME',
                'FOR_NUMERO',
                'FOR_CEP',
                'FOR_CNPJ',
                'FOR_INSC',
                'FOR_STATUS',
                'FOR_COMPLEMENTO'
            );

            $this->queryManager
                ->setAcao(Acao::UPDATE)
                ->setTabela($tabela)
                ->setValores(
                    "'$request->FOR_NOME'",
                    "'$request->FOR_NUMERO'",
                    "'$request->FOR_CEP'",
                    "'$request->FOR_CNPJ'",
                    "'$request->FOR_INSC'",
                    "'$request->FOR_STATUS'",
                    "'$request->FOR_COMPLEMENTO'"
                )
                ->setCondicao('FOR_ID', Operador::IGUAL, $identificador)
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
                ->setCondicao('FOR_ID', Operador::IGUAL, strval($identificador))
                ->queryExec();

            return ['error' => false, 'message' => 'Registro removido com sucesso.'];
        }
    }
}
