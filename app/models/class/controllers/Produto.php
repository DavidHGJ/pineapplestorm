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
            $retornoConsulta = $this->queryManager
                ->setAcao(Acao::SELECT)
                ->setTabela($this->tabela)
                ->queryExec();
        else
            $retornoConsulta = $this->queryManager
                ->setAcao(Acao::SELECT)
                ->setTabela($this->tabela)
                ->setCondicao('PRD_ID', Operador::IGUAL, strval($identificador))
                ->queryExec();

        QueryManager::reset();

        if ($retornoConsulta->rowCount() > 0) {

            $retornoConsulta = $retornoConsulta->fetchAll();

            foreach ($retornoConsulta as $index => $dado)
            {

                $response[$index]['PRD_ID'] = $dado->PRD_ID;

                $categoria = new Categoria;

                $response[$index]['CAT_ID'] = $categoria->get($dado->CAT_ID);

                unset($categoria);

                $fornecedor = new Fornecedor;

                $response[$index]['FOR_ID'] = $fornecedor->get($dado->FOR_ID);

                unset($fornecedor);

                $response[$index]['PRD_DESC'] = $dado->PRD_DESC;
                $response[$index]['PRD_PESO'] = $dado->PRD_PESO;
                $response[$index]['PRD_STATUS'] = $dado->PRD_STATUS;
                $response[$index]['PRD_QTD'] = $dado->PTD_QTD;
                $response[$index]['PRD_REGDATE'] = $dado->PRD_REGDATE;
            }

            var_dump($response);
            exit;

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
