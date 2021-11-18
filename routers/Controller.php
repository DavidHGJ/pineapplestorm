<?php

// header('Content-type: application/json');

switch (METHOD) {

    case 'GET':
        if ($url[1] != null)
            $identificador = Filtro::validarDado($url[1], 'int');
        else
            $identificador = null;
        break;

    case 'POST';
    case 'PUT':
        $request = json_decode(file_get_contents("php://input"));
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");
        if (is_null($request)) {
            echo json_encode(['error' => true, 'message' => 'Requisição invalida.', 'code' => '1']);
            exit;
        }

        if (METHOD == 'PUT') {
            if ($url[1] != null)
                $identificador = Filtro::validarDado($url[1], 'int');
            else {
                echo json_encode(['error' => true, 'message' => 'Espera-se um ID para realizar a alteração.', 'code' => '2']);
                exit;
            }
        }
        break;

    case 'DELETE':
        if ($url[1] != null)
            $identificador = Filtro::validarDado($url[1], 'int');
        else {
            echo json_encode(['error' => true, 'message' => 'Espera-se um ID para realizar a remoção.', 'code' => '3']);
            exit;
        }
        break;
}

try
{
    require_once $rota->getRota();
}
catch (PDOException $erro)
{
    http_response_code(500);

    echo json_encode(['error' => true, 'message' => 'Erro interno.', 'exception' => $erro->getMessage()]);
}
