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
class SaidaNF
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
            $retornoConsulta = $this->queryManager
                ->setAcao(Acao::SELECT)
                ->setTabela($this->tabela)
                ->queryExec();
        else
            $retornoConsulta = $this->queryManager
                ->setAcao(Acao::SELECT)
                ->setTabela($this->tabela)
                ->setCondicao('SAI_ID', Operador::IGUAL, strval($identificador))
                ->queryExec();

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

        $saida = new Saida;

        $saida->post($request, $idNotaFiscal);

        $idEntrada = QueryManager::getInstance()->getConexao()->lastInsertId();

        unset($saida);

        foreach($request->ITENS as $item)
        {
            $itemSaida = new ItemSaida;

            $itemSaida->post($item, $idEntrada);

            unset($itemSaida);
        }

        return ['error' => false, 'message' => 'Operação realizada com sucesso.'];
    }
}
