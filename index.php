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