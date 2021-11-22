<?php

use models\class\controllers\EntradaNf;

$EntradaNf = new EntradaNf;

//NF Entrada Itens de entrada.

switch(METHOD) {

    case 'GET':
        echo json_encode($EntradaNf->get($identificador));
    break;

    case 'POST':
        echo json_encode($EntradaNf->post($request));
    break;
}