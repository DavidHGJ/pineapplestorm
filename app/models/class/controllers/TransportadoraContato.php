<?php

namespace models\class\controllers;

use models\class\controllers\iController;
use models\class\queryManager\Acao;
use models\class\queryManager\Operador;
use models\class\queryManager\QueryManager;
use models\class\queryManager\Tabela;
use models\class\queryManager\TableManager;
use PDO;

/**
 *## Classe responsável pelo endpoint das transportadora.
 */
class TransportadoraContato implements iController
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
        $this->tabela = $this->tabelaManager->getTabela("transportadora_x_contato");
    }

    public function get($identificador)
    {
        if (is_null($identificador))
            $retornoConsulta = $this->queryManager->getConexao()->query("
                SELECT 
                    x.trs_id AS TRS_ID,
                    c.cnt_id AS CNT_ID,
                    c.tpc_id AS TPC_ID,
                    c.cnt_desc AS CNT_DESC
                FROM 
                    transportadora_x_contato as x 
                LEFT JOIN contato as c 
                ON 
                    x.cnt_id = c.cnt_id");
        else
            $retornoConsulta = $this->queryManager->getConexao()->query("
                SELECT 
                    x.trs_id AS TRS_ID,
                    c.cnt_id AS CNT_ID,
                    c.tpc_id AS TPC_ID,
                    c.cnt_desc AS CNT_DESC
                FROM 
                    transportadora_x_contato as x 
                LEFT JOIN contato as c 
                ON 
                    x.cnt_id = c.cnt_id
                WHERE
                    trs_id = $identificador");
                    
        if ($retornoConsulta->rowCount() > 0) {
            $response = ['error' => false, 'message' => ''];

            $response['data'] = $retornoConsulta->fetchAll();
        } else
            $response[] = ['error' => true, 'message' => 'Nenhum dado encontrado.'];

        return $response;
    }

    public function post($request)
    {
        $contato = new Contato;

        $idContato = $contato->post($request);

        unset($contato);

        $this->tabela->setColuna(
            'TRS_ID',
            'CNT_ID'
        );

        $retornoConsulta = $this->queryManager
            ->setAcao(Acao::INSERT)
            ->setTabela($this->tabela)
            ->setValores(
                "'$request->TRS_ID'",
                "'$idContato'"
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
            $return = $this->queryManager->getConexao()->query("
                UPDATE 
                    contato
                    left join transportadora_x_contato for_x_con
                        on for_x_con.cnt_id = contato.cnt_id 
                SET 
                    tpc_id = '$request->TPC_ID',
                    cnt_desc = '$request->CNT_DESC'
                where
                    for_x_con.trs_id = $identificador
                    and for_x_con.cnt_id = $request->CNT_ID
            ");

            return ($return) 
                ? ['error' => false, 'message' => 'Registro alterado com sucesso.']
                : [ 'error' => true, 'message' => 'Não foi possível alterar o registro'];
        }
    }

    public function delete($identificador)
    {
        if (is_null($identificador))
            return ['error' => true, 'message' => 'Não foi possível realizar a operação.'];
        else {
            
            $request = json_decode(file_get_contents("php://input"));

            $return = $this->queryManager->getConexao()->query("
                DELETE FROM
                    transportadora_x_contato
                WHERE
                    trs_id = '$identificador'
                    and
                    cnt_id = '$request->CNT_ID'
            ");

            if ($return)
                $this->queryManager->getConexao()->query("
                    DELETE FROM
                        contato
                    WHERE
                        cnt_id = '$request->CNT_ID'
                ");

            return ['error' => false, 'message' => 'Registro removido com sucesso.'];
        }
    }
}
