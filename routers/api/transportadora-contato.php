<?php

use models\class\controllers\TransportadoraContato;

$TransportadoraContato = new TransportadoraContato;

switch(METHOD) {

    case 'GET':
        echo json_encode($TransportadoraContato->get($identificador));
    break;

    case 'POST':
        echo json_encode($TransportadoraContato->post($request));
    break;

    case 'PUT':
        echo json_encode($TransportadoraContato->put($request, $identificador));
    break;

    case 'DELETE':
        echo json_encode($TransportadoraContato->delete($identificador));
    break;
}