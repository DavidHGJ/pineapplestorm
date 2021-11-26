<?php

use models\class\controllers\FornecedorContato;
use models\class\controllers\Transportadora;

$fornecedorContato = new FornecedorContato;

switch(METHOD) {

    case 'GET':
        echo json_encode($fornecedorContato->get($identificador));
    break;

    case 'POST':
        echo json_encode($fornecedorContato->post($request));
    break;

    case 'PUT':
        echo json_encode($fornecedorContato->put($request, $identificador));
    break;

    case 'DELETE':
        echo json_encode($fornecedorContato->delete($identificador));
    break;
}