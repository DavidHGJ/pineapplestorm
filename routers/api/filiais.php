<?php

switch(METHOD) {

    case 'GET':
        echo json_encode('recuperar');
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