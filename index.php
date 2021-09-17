<?php

use models\class\module\Rota;

require 'app/models/autoload.php';
require 'vendor/autoload.php';

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

$rota = new Rota($url);

require_once PATH_ROOT . 'routers/Controller.php';

// $request = json_decode(file_get_contents("php://input"));

// header('Content-type: application/json');
// echo json_encode(['id' => 1, 'nome' => "david"]);

// if ($_REQUEST['url'] != null)
//     $urlAtual = explode('/', $_REQUEST['url']);
// else json_encode(false);

// $rota = new Rota($urlAtual);

// require_once $rota->caminhoPagina;