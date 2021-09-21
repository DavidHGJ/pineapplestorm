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
class Transportadora implements iController {
    
    private QueryManager $queryManager;
    private TableManager $tabelaManager;

    /**
     *## Construtor
     */
    public function __construct() {
        $this->queryManager = QueryManager::getInstance();
        $this->tabelaManager = TableManager::getInstance();
    }

    public function get($identificador) {
        
        $tabela = $this->tabelaManager->getTabela('transportadora');

        if (is_null($identificador)) 
            $this->queryManager->setAcao(Acao::SELECT)->setTabela($tabela);
        else
            $this->queryManager
                ->setAcao(Acao::SELECT)
                ->setTabela($tabela)
                ->setCondicao('id', Operador::IGUAL, strval($identificador));

        return $this->queryManager->queryExec();
    }

    public function post() {}

    public function put() {}

    public function delete() {}
}
