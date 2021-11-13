<?php

use models\class\controllers\Categoria;

$categoria = new Categoria;

switch(METHOD) {

    case 'GET':
        echo json_encode($categoria->get($identificador));
    break;

    case 'POST':
        echo json_encode($categoria->post($request));
    break;

    case 'PUT':
        echo json_encode($categoria->put($request, $identificador));
    break;

    case 'DELETE':
        echo json_encode($categoria->delete($identificador));
    break;
}