<?php

use models\class\controllers\EntradaNf;
use models\class\controllers\SaidaNF;

$saidaNF = new SaidaNF;

//NF Entrada Itens de entrada.

switch(METHOD) {

    case 'GET':
        echo json_encode($saidaNF->get($identificador));
    break;

    case 'POST':
        echo json_encode($saidaNF->post($request));
    break;
}