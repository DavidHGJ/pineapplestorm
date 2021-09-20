<?php

use models\class\queryManager\Acao;
use models\class\queryManager\Operador;
use models\class\queryManager\QueryManager;
use models\class\util\Rota;
use models\class\queryManager\TableManager;

require 'app/models/autoload.php';
require 'vendor/autoload.php';


$tableManager = TableManager::getInstance();
$tabela = $tableManager->getTabela("usuario");
$queryManager = QueryManager::getInstance();
$con = $queryManager-> getConexao();
$queryManager-> 
    setAcao(Acao::SELECT)->
    setTabela($tabela)->
    setCondicao("usr_login", Operador::IGUAL, $con->quote("willian"))->
    addCondicao("AND", "usr_senha", Operador::LIKE, $con->quote("%2%"))->
    addCondicao("OR", "usr_nome", Operador::LIKE, $con->quote("will%"))->
    addCondicao("AND", "usr_nome", Operador::IS_NOT_NULL)
    ;

$var = ($queryManager-> queryExec()-> fetch());

echo "<pre>";
var_dump($var);



/*

if ($_REQUEST['url'] != null)
    $urlAtual = explode('/', $_REQUEST['url']);
else $urlAtual[] = 'login';

$rota = new Rota($urlAtual);

require_once $rota->caminhoPagina;
*/