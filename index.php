<?php

<<<<<<< HEAD
use models\class\queryManager\Acao;
use models\class\queryManager\Operador;
use models\class\queryManager\QueryManager;
use models\class\util\Rota;
use models\class\queryManager\TableManager;
=======
use models\class\module\Rota;
>>>>>>> 5a5d53bf702c2126e1c10519faa629169b9124e8

require 'app/models/autoload.php';
require 'vendor/autoload.php';

<<<<<<< HEAD

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
=======
try {
    if ($_REQUEST['url'] != null)
        $url = explode('/', $_REQUEST['url']);
    else throw new Exception('Acesso negado, URL inserida invalida.', '0');
}
catch (Exception $erro) {
    header('Content-type: application/json');
    echo json_encode(['error' => true, 'message' => $erro->getMessage(), 'code' => $erro->getCode()]);
    exit;
}
>>>>>>> 5a5d53bf702c2126e1c10519faa629169b9124e8

$rota = new Rota($url);

<<<<<<< HEAD
require_once $rota->caminhoPagina;
*/
=======
require_once PATH_ROOT . 'routers/Controller.php';
>>>>>>> 5a5d53bf702c2126e1c10519faa629169b9124e8
