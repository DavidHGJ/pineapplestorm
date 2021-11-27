<?php

use models\class\controllers\FilialContato;

$filialContato = new FilialContato;

switch(METHOD) {

    case 'GET':
        echo json_encode($filialContato->get($identificador));
    break;

    case 'POST':
        echo json_encode($filialContato->post($request));
    break;

    case 'PUT':
        echo json_encode($filialContato->put($request, $identificador));
    break;

    case 'DELETE':
        echo json_encode($filialContato->delete($identificador));
    break;
}