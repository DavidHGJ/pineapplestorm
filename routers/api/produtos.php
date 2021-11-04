<?php

use models\class\controllers\Produto;

$produto = new Produto;

switch(METHOD) {

    case 'GET':
        echo json_encode($produto->get($identificador));
    break;

    case 'POST':
        echo json_encode($produto->post($request));
    break;

    case 'PUT':
        echo json_encode($produto->put($request, $identificador));
    break;

    case 'DELETE':
        echo json_encode($produto->delete($identificador));
    break;
}