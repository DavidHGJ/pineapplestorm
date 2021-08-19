<?php

use models\class\rota;

require 'app/models/autoload.php';
require 'vendor/autoload.php';

$urlAtual = explode('/', $_REQUEST['url']);

$rota = new rota($urlAtual);

require_once $rota->caminhoPagina;