<?php

use models\class\controllers\Transportadora;

$transportadora = new Transportadora;

switch(METHOD) {

    case 'GET':
        echo json_encode($transportadora->get($identificador));
    break;

    case 'POST':
        echo json_encode($transportadora->post($request));
    break;

    case 'PUT':
        echo json_encode($transportadora->put($request, $identificador));
    break;

    case 'DELETE':
        echo json_encode($transportadora->delete($identificador));
    break;
}