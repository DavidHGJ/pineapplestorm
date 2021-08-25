<?php

$request = $_REQUEST;

if (!file_exists('processos/' . $request['destino'] . '.php'))
    header('Location:' . URL . PAGINA_INICIAL);
else
    require_once 'processos/' . $request['destino'] . '.php';