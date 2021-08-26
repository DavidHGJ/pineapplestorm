<?php

use models\class\queryManager\QueryManager;
use models\class\queryManager\Tabela;
use models\class\util\Rota;

require 'app/models/autoload.php';
require 'vendor/autoload.php';

if ($_REQUEST['url'] != null)
    $urlAtual = explode('/', $_REQUEST['url']);
else $urlAtual[] = 'login';

$rota = new Rota($urlAtual);

$queryManager = QueryManager::getInstance();
$tabela = new Tabela('usuario', 'usr_login', 'usr_senha', 'usr_regdate');

$queryManager->setAcao('select')->setTabela($tabela);
echo '<pre>';
var_dump($queryManager->queryExec()->fetch()->USR_LOGIN);

//require_once $rota->caminhoPagina;