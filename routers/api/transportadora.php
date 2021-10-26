<?php

use models\class\controllers\Transportadora;

$transportadora = new Transportadora;

switch(METHOD) {

    case 'GET':
        $retornoConsulta = $transportadora->get($identificador);

        if ($retornoConsulta->rowCount() > 0)
        {
            $response[] = ['error' => false, 'message' => ''];

            $response[] = $retornoConsulta->fetchAll();

            echo json_encode($response);
        }
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