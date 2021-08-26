<?php

$request = $_REQUEST;

if (!file_exists(PATH_ROOT . 'api\\processos\\' . $request['destino'] . '.php'))
    header('Location:' . URL . PAGINA_INICIAL);
else
    require_once 'processos/' . $request['destino'] . '.php';