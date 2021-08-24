<?php

use models\class\util\Rota;

require 'app/models/autoload.php';
require 'vendor/autoload.php';

$urlAtual = explode('/', $_REQUEST['url']);


if (empty($urlAtual)) $urlAtual[] = 'login';
var_dump($urlAtual); exit;

$rota = new Rota($urlAtual);

require_once $rota->caminhoPagina;