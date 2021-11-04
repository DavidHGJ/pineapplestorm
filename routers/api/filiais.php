<?php

use models\class\controllers\Filial;

$filial = new Filial;

switch(METHOD) {

    case 'GET':
        echo json_encode($filial->get($identificador));
    break;

    case 'POST':
        echo json_encode($filial->post($request));
    break;

    case 'PUT':
        echo json_encode($filial->put($request, $identificador));
    break;

    case 'DELETE':
        echo json_encode($filial->delete($identificador));
    break;
}