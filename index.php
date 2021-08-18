<?php

use models\class\Rota;

require 'vendor/autoload.php';
require 'app/models/class/rota.php';

$urlAtual = explode('/', $_REQUEST['url']);

$rota = new Rota($urlAtual);

require_once $rota->caminhoPagina;