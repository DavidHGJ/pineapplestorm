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

require_once $rota->caminhoPagina;