<?php

use models\class\queryManager\QueryManager;
<<<<<<< HEAD
=======
use models\class\queryManager\Tabela;
use models\class\queryManager\TableManager;
>>>>>>> 75684545782bd993b480f41dee342759386dc105
use models\class\util\Rota;
use models\class\queryManager\TableManager;

require 'app/models/autoload.php';
require 'vendor/autoload.php';

//$tableManager = TableManager::getInstance();
//$queryManager = QueryManager::getInstance()-> setAcao("SELECT")-> setTabela($tableManager->getTabela("usuario"));

if ($_REQUEST['url'] != null)
    $urlAtual = explode('/', $_REQUEST['url']);
else $urlAtual[] = 'login';

$rota = new Rota($urlAtual);

require_once $rota->caminhoPagina;
