<?php

use models\class\controllers\Fornecedor;

$fornecedor = new Fornecedor;

switch(METHOD) {

    case 'GET':
        echo json_encode($fornecedor->get($identificador));
    break;

    case 'POST':
        echo json_encode($fornecedor->post($request));
    break;

    case 'PUT':
        echo json_encode($fornecedor->put($request, $identificador));
    break;

    case 'DELETE':
        echo json_encode($fornecedor->delete($identificador));
    break;
}