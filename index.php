<?php

use models\class\Rota;

require 'app/models/autoload.php';
require 'vendor/autoload.php';

$urlAtual = explode('/', $_REQUEST['url']);

$rota = new Rota($urlAtual);

require_once $rota->caminhoPagina;