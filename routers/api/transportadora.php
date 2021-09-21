<?php

use models\class\controllers\Transportadora;

$transportadora = new Transportadora;

switch(METHOD) {

    case 'GET':
        $transportadora->get($identificador);
    break;

    case 'POST':
        echo json_encode('inserir');
    break;

    case 'PUT':
        echo json_encode('alterar');
    break;

    case 'DELETE':
        echo json_encode('deletar');
    break;
}